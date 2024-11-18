<!DOCTYPE html>
<html>
	<?php // require_once "session.php";
?>
<head>
	<meta charset="utf-8"/>
	<script src="script.js" type="text/javascript"></script>
</head>

<body>
	<div>
		<h1>Добавление поездки</h1>
		<form action="/add_trip.php">
			<label for="regions">Регион</label>
			<select id="regions" name="regions">
				<option value="Санкт-Петербург">Санкт-Петербург</option>
				<option value="Уфа">Уфа</option>
				<option value="Нижний Новгород">Нижний Новгород</option>
				<option value="Владимир">Владимир</option>
			</select>
			<br><br>
			<label for="date_departure">Дата выезда из Москвы</label>
			<input type="date" id="date_departure" name="date_departure"/>

			<br><br>
			<label for="couriers">ФИО курьера</label>
			<select id="couriers" name="couriers">
				<option value="Иванов">Иванов</option>
				<option value="Петров">Петров</option>
				<option value="Сидоров">Сидоров</option>
			</select>
			<br><br>
			<label for="date_arrival">Дата прибытия в регион</label>
			<label id="date_arrival">???</label>
			<br><br>

			<input type="submit" value="Добавить">
		</form>
	</div>
</body>
</html>