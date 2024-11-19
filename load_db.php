<?php
require_once "config.php";
global $db;

$query = "SELECT * FROM regions";
$result = mysqli_query($db, $query);
$regions = [];

while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	$regions += [$row[0] => [$row[1], $row[2]]];
}

asort($regions);

$query = "SELECT * FROM couriers";
$result = mysqli_query($db, $query);
$couriers = [];

while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	$couriers += [$row[0] => implode(" ", array_slice($row, 1))];
}

asort($couriers);
?>
