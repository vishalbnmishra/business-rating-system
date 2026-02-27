<?php
include '../db.php';

echo '<option value="">Select Business</option>';

$res = $conn->query("SELECT b_id, b_name FROM business ORDER BY b_name ASC");

while($b = $res->fetch_assoc()){
    echo '<option value="'.$b['b_id'].'">'.$b['b_name'].'</option>';
}