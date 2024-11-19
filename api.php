<?php
require_once "config.php";

global $db;
$query = "SELECT * FROM regions";
$result = mysqli_query($db, $query);
$regions = [];

while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	// $regions += [$row[0] => [$row[1], $row[2]]];
	$regions += [$row[0] => $row];
}

echo json_encode($regions);

// $reg = array(1, 1, 1, 1, 1);
// echo json_encode([[1,2,3,4,5], [2,3,5,6,7]]);
?>