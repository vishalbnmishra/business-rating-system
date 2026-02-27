<?php
include '../db.php';

$id = $_POST['id'];

$conn->query("DELETE FROM business WHERE b_id=$id");

echo json_encode(["status" => "success"]);