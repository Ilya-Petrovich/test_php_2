<?php
require_once "config.php";

global $db;
$query = "SELECT * FROM couriers";
$result = mysqli_query($db, $query);
$couriers = [];

while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	$couriers += [$row[0] => $row];
}

echo json_encode($couriers);
?>