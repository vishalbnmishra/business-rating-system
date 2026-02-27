<?php include 'db.php'; ?>
<?php include 'includes/header.php'; ?>


<div class="container ">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <h2 class="text-center fw-bold mb-4">
                Business Listing & Rating System
            </h2>
            <div class="text-start mb-4">
                <button class="btn btn-primary px-4 me-2" data-bs-toggle="modal" data-bs-target="#businessModal">
                    Add Business
                </button>

                <button class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#ratingModal">
                    Give Ratings
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="businessTable">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Sr</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Average Rating</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $result = $conn->query("
                            SELECT 
                                b.*,
                                IFNULL(ROUND(AVG(r.r_ratings),1),0) AS avg_rating
                            FROM business b
                            LEFT JOIN ratings r ON b.b_id = r.b_id
                            GROUP BY b.b_id
                            ORDER BY b.b_id DESC
                        ");

                        while($row = $result->fetch_assoc()){
                        ?>
                        <tr id="row_<?= $row['b_id'] ?>">
                            <td></td>
                            <td><?= $row['b_name'] ?></td>
                            <td><?= $row['b_address'] ?></td>
                            <td><?= $row['b_phone'] ?></td>
                            <td><?= $row['b_email'] ?></td>
                            <td class="text-center">
                                <div class="avg-rating" data-id="<?= $row['b_id'] ?>"
                                    data-score="<?= isset($row['avg_rating']) ? $row['avg_rating'] : 0 ?>">
                                </div>
                            </td>

                            <td class="text-center">
                                <button class="btn btn-warning btn-sm editBtn"
                                    data-id="<?= $row['b_id'] ?>">Edit</button>

                                <button class="btn btn-danger btn-sm deleteBtn"
                                    data-id="<?= $row['b_id'] ?>">Delete</button>
                            </td>
                        </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<div class="modal fade" id="businessModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg border-0">

            <div class="modal-header text-white rounded-top-4"
                style="background: linear-gradient(45deg,#0d6efd,#6610f2);">
                <h5 class="modal-title fw-bold">
                    Add Business Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">

                <form id="businessForm">

                    <input type="hidden" name="id" id="business_id">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Business Name
                        </label>
                        <input type="text" name="name" class="form-control" placeholder="Enter business name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Address
                        </label>
                        <textarea name="address" class="form-control" placeholder="Enter address" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Phone Number
                        </label>
                        <input type="text" name="phone" pattern="[0-9]{10}" class="form-control"
                            placeholder="10 digit number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Email Address
                        </label>
                        <input type="email" name="email" class="form-control" placeholder="business@gmail.com">
                    </div>
                    <button class="btn btn-primary w-100 py-2 fw-semibold shadow-sm">
                        Save Business
                    </button>

                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ratingModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg border-0">

            <div class="modal-header text-white rounded-top-4"
                style="background: linear-gradient(45deg,#28a745,#20c997);">
                <h5 class="modal-title fw-bold text-center">
                    Give Your Ratings
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">

                <form id="ratingForm">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Select Business</label>
                        <select name="business_id" id="businessSelect" class="form-select" required>
                            <option value="">Choose Business</option>

                            <?php
                            $res = $conn->query("SELECT b_id, b_name FROM business ORDER BY b_name ASC");
                            while($b = $res->fetch_assoc()){
                                echo '<option value="'.$b['b_id'].'">'.$b['b_name'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Your Name</label>
                        <input type="text" name="user_name" class="form-control" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Your Email</label>
                        <input type="email" name="user_email" class="form-control" placeholder="example@gmail.com"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Your Phone</label>
                        <input type="text" name="user_phone" class="form-control" placeholder="10 digit number"
                            required>
                    </div>
                    <div class="text-center mb-3">
                        <label class="form-label fw-semibold d-block">
                            Your Rating
                        </label>
                        <div id="user_rating"></div>
                    </div>

                    <button class="btn btn-success w-100 py-2 fw-semibold shadow-sm">
                        Submit Rating
                    </button>

                </form>

            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>