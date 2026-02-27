<?php
include "../db.php";

$stmt = $conn->prepare("SELECT * FROM business WHERE b_id=?");
$stmt->bind_param("i",$_POST['id']);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

echo json_encode($result);
?>