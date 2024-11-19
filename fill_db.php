<?php
require_once "config.php";

global $db;

$query = "SELECT * FROM couriers";
$result = mysqli_query($db, $query);
$couriers = [];
while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	// $couriers[] = $row;
	$couriers += [$row[0] => $row];
}

$query = "SELECT * FROM regions";
$result = mysqli_query($db, $query);
$regions = [];
while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	// $regions[] = $row;
	$regions += [$row[0] => $row];
}

for ($i = 0; $i < 3; $i++) {

$query = "SELECT * FROM trips";
$result = mysqli_query($db, $query);
$trips = [];
while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	// $trips[] = $row;
	$trips += [$row[0] => $row];
}

// foreach ($couriers as $key => $val) {
//     echo "$key = ";
//     print_r($val);
//     echo "<br>";
// }
// echo "<br><br>";
// foreach ($regions as $key => $val) {
// 	echo "$key = ";
//     print_r($val);
//     echo "<br>";
// }
// echo "<br><br>";
// foreach ($trips as $key => $val) {
// 	echo "$key = ";
//     print_r($val);
//     echo "<br>";
// }

// print(array_rand($couriers));
$courier_id = array_rand($couriers);
// $courier_id = 2;
$region_id = array_rand($regions);
// echo $courier_id . "<br>";
// echo $region_id . "<br>";
// $time = strtotime($trips[2][4]);
// echo $time;
// $departure_date = date('Y-m-d', $time);
$departure_date = date('Y-m-d', rand(1727733600, 1735599600)); // random date from 01.10.2024 to 31.12.2024
// $arrival_date = date('Y-m-d', rand(1735599600, 1735599600));
// $departure_date = DateTime::createFromFormat('Y-m-d', $trips[1][3]);
$departure_date = DateTime::createFromFormat('Y-m-d', $departure_date);
// echo date_format($departure_date, 'Y-m-d') . "<br>";
$arrival_date = clone $departure_date;
date_modify($arrival_date, '+'.$regions[$region_id][2].' day');
// echo date_format($arrival_date, 'Y-m-d') . "<br>";
$busy = false;
// check if generated courier is busy for generated dates
foreach ($trips as $trip) {
	if ($courier_id == $trip[1]) {
		// print("The one!<br>");
		// echo date_format($departure_date, 'Y-m-d') . "<br>";
		// echo date_format($arrival_date, 'Y-m-d') . "<br>";
		// $d = strtotime($departure_date);
		// if ($d > strtotime($trip[2]) and $d < strtotime($trip[3])) {
		// print($departure_date < DateTime::createFromFormat('Y-m-d', $trip[4]));
		if ($departure_date >= DateTime::createFromFormat('Y-m-d', $trip[3]) and $departure_date <= DateTime::createFromFormat('Y-m-d', $trip[4]) or
		$arrival_date >= DateTime::createFromFormat('Y-m-d', $trip[3]) and $arrival_date <= DateTime::createFromFormat('Y-m-d', $trip[4])) {
			$busy = true;
			break;
		}
	}
}
if (!$busy) {

	// date_modify($arrival_date, '+$regions[$region_id][2] day');
	// $departure_date + $regions[$region_id][2];
	$d = $departure_date->format('Y-m-d');
	$a = $arrival_date->format('Y-m-d');
	$query = "INSERT INTO `trips` (`id`, `courier_id`, `region_id`, `departure_date`, `arrival_date`) VALUES (NULL, $courier_id, $region_id, '$d', '$a');";

	echo $query . "<br>";
	// $result = mysqli_query($db, $query);
} else {
	print("BUSY<br>");
}


}
?>