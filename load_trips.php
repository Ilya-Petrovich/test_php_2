<?php
require_once "config.php";

global $db;
$query = "SELECT * FROM trips";
$result = mysqli_query($db, $query);
$trips = [];

while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	$trips += [$row[0] => $row];
}

echo json_encode($trips);
?>