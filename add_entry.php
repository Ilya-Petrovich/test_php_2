<?php
require_once "config.php";
global $db;

$courier_id = $_GET["courier_id"];
$region_id = $_GET["region_id"];
$departure_date = DateTime::createFromFormat('Y-m-d', $_GET["departure_date"]);
$arrival_date = DateTime::createFromFormat('Y-m-d', $_GET["arrival_date"]);
$d = $departure_date->format('Y-m-d');
$a = $arrival_date->format('Y-m-d');
$query = "INSERT INTO `trips` (`id`, `courier_id`, `region_id`, `departure_date`, `arrival_date`) VALUES (NULL, $courier_id, $region_id, '$d', '$a');";
$result = mysqli_query($db, $query);
?>