<?php
include '../db.php';

$b_id      = $_POST['business_id'];
$r_name    = $_POST['user_name'];
$r_email   = $_POST['user_email'];
$r_phone   = $_POST['user_phone'];
$r_ratings = $_POST['rating'];

if(empty($b_id)){
    echo json_encode(["error" => "Business ID missing"]);
    exit;
}

$check = $conn->prepare("
    SELECT r_id 
    FROM ratings 
    WHERE b_id=? AND r_email=?
");

$check->bind_param("is", $b_id, $r_email);
$check->execute();
$result = $check->get_result();

if($result->num_rows > 0){
    $update = $conn->prepare("
        UPDATE ratings 
        SET r_ratings=?, r_name=?, r_phone=? 
        WHERE b_id=? AND r_email=?
    ");

    $update->bind_param("dssis", $r_ratings, $r_name, $r_phone, $b_id, $r_email);
    $update->execute();

}else{
    $insert = $conn->prepare("
        INSERT INTO ratings 
        (b_id, r_name, r_email, r_phone, r_ratings)
        VALUES (?,?,?,?,?)
    ");

    $insert->bind_param("isssd", $b_id, $r_name, $r_email, $r_phone, $r_ratings);
    $insert->execute();
}

$avgQuery = $conn->prepare("
    SELECT IFNULL(ROUND(AVG(r_ratings),1),0) as avg_rating
    FROM ratings
    WHERE b_id=?
");

$avgQuery->bind_param("i", $b_id);
$avgQuery->execute();
$avgResult = $avgQuery->get_result()->fetch_assoc();

echo json_encode([
    "business_id" => $b_id,
    "avg_rating"  => $avgResult['avg_rating']
]);