let table;
let currentRating = 0;

$(document).ready(function () {

    table = $('#businessTable').DataTable({
        columnDefs: [{
            targets: 0,
            searchable: false,
            orderable: false
        }],
        order: [[1, 'asc']]
    });

    table.on('order.dt search.dt draw.dt', function () {
        table.column(0, { search: 'applied', order: 'applied' })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });

        initStars();
    }).draw();


    function initStars() {
        $('.avg-rating').each(function () {

            if (!$(this).hasClass('raty-loaded')) {

                $(this).raty({
                    path: 'assets/js/Full-featured-Star-Rating-Plugin-For-jQuery-Raty/src/images',
                    readOnly: true,
                    half: true,
                    score: $(this).attr('data-score')
                });

                $(this).addClass('raty-loaded');
            }
        });
    }

    initStars();


   
    $('#businessForm').submit(function (e) {
        e.preventDefault();

        let id    = $('#business_id').val();
        let name  = $('input[name="name"]').val().trim();
        let phone = $('input[name="phone"]').val().trim();
        let email = $('input[name="email"]').val().trim();

   

        if (name === "") { alert("Business name is required"); return; }

        if (email === "") { alert("Email is required"); return; }

        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            alert("Enter valid email address");
            return;
        }

        if (phone === "") { alert("Phone number is required"); return; }

        let phonePattern = /^[0-9]{10}$/;
        if (!phonePattern.test(phone)) {
            alert("Phone number must be exactly 10 digits");
            return;
        }

        $.post('ajax_files/save_business.php', $(this).serialize(), function (response) {
            

            let data = JSON.parse(response);

            if (data.status === "error") {
                alert(data.message);
                return;
            }

            if (data.type === "insert") {

                table.row.add([
                    "",
                    data.b_name,
                    data.b_address,
                    data.b_phone,
                    data.b_email,
                    '<div class="avg-rating" data-id="' + data.b_id + '" data-score="0"></div>',
                    actionButtons(data.b_id)
                ]).draw(false);

                initStars();
                $.get('ajax_files/get_business_dropdown.php', function(html){
                    $('#businessSelect').html(html);
                });
            }

            else if (data.type === "update") {

                let row = $('#row_' + data.b_id);

                table.row(row).data([
                    "",
                    data.b_name,
                    data.b_address,
                    data.b_phone,
                    data.b_email,
                    row.find('td:eq(5)').html(), 
                    actionButtons(data.b_id)
                ]).draw(false);
            }

            $('#businessModal').modal('hide');
            $('#businessForm')[0].reset();
            $('#business_id').val('');
        });
    });


    $(document).on('click', '.editBtn', function () {

        let id = $(this).data('id');

        $.post('ajax_files/get_business.php', { id: id }, function (res) {

            let data = JSON.parse(res);

            $('#business_id').val(data.b_id);
            $('input[name="name"]').val(data.b_name);
            $('textarea[name="address"]').val(data.b_address);
            $('input[name="phone"]').val(data.b_phone);
            $('input[name="email"]').val(data.b_email);

            $('#businessModal').modal('show');
        });
    });


    $(document).on('click', '.deleteBtn', function () {

        if (!confirm("Are you sure?")) return;
        let id = $(this).data('id');
        let row = $(this).closest('tr');
        $.post('ajax_files/delete_business.php', { id: id }, function (response) {
            let data = JSON.parse(response);
            if (data.status === "success") {
                table.row(row).remove().draw(false);
                $('#businessSelect option[value="'+id+'"]').remove();

            } else {
                alert("Delete failed");
            }
        });
    });


    $('#ratingModal').on('shown.bs.modal', function () {

        $('#user_rating').empty();
        currentRating = 0;

        $('#user_rating').raty({
            path: 'assets/js/Full-featured-Star-Rating-Plugin-For-jQuery-Raty/src/images',
            half: true,
            click: function (score) {
                currentRating = score;
            }
        });
    });


    $('#ratingForm').submit(function (e) {
        e.preventDefault();

        let formData = $(this).serialize() + '&rating=' + currentRating;

        $.post('ajax_files/submit_rating.php', formData, function (res) {

            let data = JSON.parse(res);

            let ratingDiv = $('.avg-rating[data-id="' + data.business_id + '"]');

            ratingDiv.attr('data-score', data.avg_rating);
            ratingDiv.removeClass('raty-loaded');
            ratingDiv.raty('destroy');

            ratingDiv.raty({
                path: 'assets/js/Full-featured-Star-Rating-Plugin-For-jQuery-Raty/src/images',
                readOnly: true,
                half: true,
                score: data.avg_rating
            });

            ratingDiv.addClass('raty-loaded');

            $('#ratingModal').modal('hide');
            $('#ratingForm')[0].reset();
        });
    });


    $('#businessModal').on('hidden.bs.modal', function () {
        $('#businessForm')[0].reset();
        $('#business_id').val('');
    });

});

function actionButtons(id) {
    return `
        <button class="btn btn-warning btn-sm editBtn" data-id="${id}">Edit</button>
        <button class="btn btn-danger btn-sm deleteBtn" data-id="${id}">Delete</button>
    `;
}