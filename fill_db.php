<?php
require_once "config.php";

global $db;

$query = "SELECT * FROM couriers";
$result = mysqli_query($db, $query);
$couriers = [];
while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	$couriers += [$row[0] => $row];
}

$query = "SELECT * FROM regions";
$result = mysqli_query($db, $query);
$regions = [];
while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	$regions += [$row[0] => $row];
}

for ($i = 0; $i < 30; $i++) {
	$query = "SELECT * FROM trips";
	$result = mysqli_query($db, $query);
	$trips = [];
	while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
		$trips += [$row[0] => $row];
	}

	$courier_id = array_rand($couriers);
	$region_id = array_rand($regions);
	$departure_date = date('Y-m-d', rand(1727733600, 1735599600)); // random date from 01.10.2024 to 31.12.2024
	$departure_date = DateTime::createFromFormat('Y-m-d', $departure_date);
	$arrival_date = clone $departure_date;
	date_modify($arrival_date, '+'.$regions[$region_id][2].' day');
	$busy = false;

	// check if generated courier is busy for generated dates
	foreach ($trips as $trip) {
		if ($courier_id == $trip[1]) {
			if ($departure_date >= DateTime::createFromFormat('Y-m-d', $trip[3]) and $departure_date <= DateTime::createFromFormat('Y-m-d', $trip[4]) or
			$arrival_date >= DateTime::createFromFormat('Y-m-d', $trip[3]) and $arrival_date <= DateTime::createFromFormat('Y-m-d', $trip[4])) {
				$busy = true;
				break;
			}
		}
	}

	if (!$busy) {
		$d = $departure_date->format('Y-m-d');
		$a = $arrival_date->format('Y-m-d');
		$query = "INSERT INTO `trips` (`id`, `courier_id`, `region_id`, `departure_date`, `arrival_date`) VALUES (NULL, $courier_id, $region_id, '$d', '$a');";
		$result = mysqli_query($db, $query);
	}
}
?>