<?php
include "../db.php";

$business_id = $_POST['business_id'];

$stmt = $conn->prepare("
    SELECT IFNULL(ROUND(AVG(r_ratings),1),0) as avg_rating
    FROM ratings
    WHERE b_id=?
");

$stmt->bind_param("i", $business_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

echo json_encode([
    "avg" => $result['avg_rating'] ?? 0
]);