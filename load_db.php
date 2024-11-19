<?php
require_once "config.php";

// session_id($session_id);
// session_start();
global $db;
$query = "SELECT * FROM regions";
$result = mysqli_query($db, $query);
$regions = [];

while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	// array_push($regions, $row);
	$regions += [$row[0] => [$row[1], $row[2]]];
	// $regions[] = $row;
	// $regions[] = array($row[0], implode(" ", array_slice($row, 1)));
}

// print_r($regions);
asort($regions);
// echo "<br>";
// print_r($regions);
// foreach ($regions as $key => $val) {
//     echo "$key = $val\n";
// }

$query = "SELECT * FROM couriers";
$result = mysqli_query($db, $query);
$couriers = [];

while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
	// $rows[] = json_encode($row);
	$couriers += [$row[0] => implode(" ", array_slice($row, 1))];
	// echo implode(" ", array_slice($row, 1)) . "<br>";
	// $couriers[] = array($row[0], implode(" ", array_slice($row, 1)));
}
// print_r($couriers);
asort($couriers);
// print_r($couriers);

// $result = mysqli_query($db, "SHOW TABLES LIKE 'temp_tasks'");
//
// if ($result = mysqli_fetch_array($result)) {
// 	// echo "Table already exists!"."<br>";
// } else {
// 	$result = mysqli_query($db, $query);
//
// 	if ($result === TRUE) {
// 		echo "Table temp_tasks created successfully!"."<br>";
// 	} else {
// 		echo "Error creating table: ". $db->error ."<br>";
// 	}
// }

function load_tasks($session_id) {
	session_id($session_id);
	session_start();
	global $db;
	$query = "SELECT * FROM " . $_SESSION["organizations"][0] . "_tasks";
	$result = mysqli_query($db, $query);
	$rows = [];

	while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
		// $rows[] = json_encode($row);
		$rows[] = $row;
	}
	// $tasks = $rows;
	$tasks = json_encode($rows, JSON_UNESCAPED_UNICODE);
	return $tasks;
}

// Get organizations of active user
// print_r($_SESSION);

if (isset($_SESSION["userid"])) {

	$query = "SELECT org_id FROM org_users WHERE user_id = " . $_SESSION["userid"]; // Change for variable later !!!
	$result = mysqli_query($db, $query);
	$org_ids = [];


	while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
		// $org_ids[] = json_encode($row);
		array_push($org_ids, [$row[0], "ss"]);
	}


	$_SESSION["organizations"] = $org_ids[0];


	// 1 for three of us

	// echo json_decode($_SESSION["organizations"][0]);
	// echo $_SESSION["organizations"][0];

	// Get names of organizations
	$query = "SELECT name FROM organizations WHERE org_id = " . $_SESSION["organizations"][0];
	$result = mysqli_query($db, $query);
	$name = mysqli_fetch_array($result, MYSQLI_NUM);
	// echo $name[0];
	$_SESSION["org_names"] = $name;

	$orgs = [$org_ids[0][0], $name[0]];

	// print_r($orgs);

	// $orgs = json_encode($orgs, JSON_UNESCAPED_UNICODE);

	// print_r($_SESSION["org_names"]);


	$tasks = load_tasks();
	// print_r($tasks);

	$query = "SELECT id, name FROM users";
	$result = mysqli_query($db, $query);
	$rows = [];

	while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
		// $rows[] = json_encode($row);
		$rows[] = $row;
	}

	$current_user = ["Undefined", "Undefined"];

	for ($i = 0; $i < count($rows); $i++ ) {
		if ($rows[$i][0] == $_SESSION["userid"]) {
			$current_user = [];
			array_push($current_user, $rows[$i][0]);
			array_push($current_user, $rows[$i][1]);
			// $current_user[] = $rows[$i][1];
		}
	}

	// echo "==================";
	// echo $current_user;
	// // print_r($_SESSION);
	// echo "==================";

	$users = json_encode($rows, JSON_UNESCAPED_UNICODE);



	if (!empty($_POST)) {
		if ($_POST["text"] == "tasks") {
			// $tasks = stripslashes($tasks);
			echo $tasks;
		} else if ($_POST["text"] == "users") {
			// $users = stripslashes($users);
			echo $users;
		} else if ($_POST["text"] == "organizations") {
			echo json_encode($orgs, JSON_UNESCAPED_UNICODE);
		} else if ($_POST["text"] == "user_info") {
			echo json_encode($current_user, JSON_UNESCAPED_UNICODE);

		} else {
			// DO NOTHING !!!!
		}
	}
}
?>
