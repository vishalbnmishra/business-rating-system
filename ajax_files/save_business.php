<?php
include "../db.php";

$name    = $_POST['name'];
$address = $_POST['address'];
$phone   = $_POST['phone'];
$email   = $_POST['email'];
$id      = isset($_POST['id']) ? $_POST['id'] : "";

if(empty($name)){
    echo json_encode(["status"=>"error","message"=>"Business name is required"]);
    exit;
}
if(empty($email)){
    echo json_encode(["status"=>"error","message"=>"Email is required"]);
    exit;
}
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo json_encode(["status"=>"error","message"=>"Invalid email format"]);
    exit;
}
if(empty($phone)){
    echo json_encode(["status"=>"error","message"=>"Phone is required"]);
    exit;
}
if(!preg_match('/^[0-9]{10}$/', $phone)){
    echo json_encode(["status"=>"error","message"=>"Phone must be 10 digits"]);
    exit;
}
if(empty($id)){

    $check = $conn->prepare("
        SELECT b_id FROM business
        WHERE b_name=? OR b_email=? OR b_phone=?
    ");
    $check->bind_param("sss",$name,$email,$phone);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0){
        echo json_encode([
            "status"=>"error",
            "message"=>"Business already exists!"
        ]);
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO business (b_name,b_address,b_phone,b_email)
        VALUES (?,?,?,?)
    ");

    $stmt->bind_param("ssss",$name,$address,$phone,$email);
    $stmt->execute();

    $id   = $conn->insert_id;
    $type = "insert";

} else {

    $check = $conn->prepare("
        SELECT b_id FROM business
        WHERE (b_name=? OR b_email=? OR b_phone=?)
        AND b_id != ?
    ");
    $check->bind_param("sssi",$name,$email,$phone,$id);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0){
        echo json_encode([
            "status"=>"error",
            "message"=>"Business already exists!"
        ]);
        exit;
    }

    $stmt = $conn->prepare("
        UPDATE business
        SET b_name=?,b_address=?,b_phone=?,b_email=?
        WHERE b_id=?
    ");

    $stmt->bind_param("ssssi",$name,$address,$phone,$email,$id);
    $stmt->execute();

    $type = "update";
}

echo json_encode([
    "status"=>"success",
    "type"=>$type,
    "b_id"=>$id,
    "b_name"=>$name,
    "b_address"=>$address,
    "b_phone"=>$phone,
    "b_email"=>$email
]);
?>