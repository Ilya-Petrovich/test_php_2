<!DOCTYPE html>
<html>
<?php
	require_once "config.php";
	require_once "load_db.php";
	// require_once "session.php";
?>
<head>
	<meta charset="utf-8"/>
	<script src="script.js" type="text/javascript"></script>
</head>

<body>
	<div>
		<h1>Добавление поездки</h1>
		<form id="form1">
			<label for="regions">Регион</label>
			<select id="regions" name="regions" onchange="onSelect();">
				<?php
				if (isset($regions)) {
					echo "<option value=0></option>";
					foreach ($regions as $key => $val) {
						echo "<option value=" . $key . ">" . $val[0] . "</option>";
					}
				} else {
					echo "<option value=null>список регионов не загружен</option>";
				}
				?>
			</select>
			<br><br>
			<label for="date_departure">Дата выезда из Москвы</label>
			<input type="date" id="date_departure" name="date_departure" onchange="onSelect();"/>

			<br><br>
			<label for="couriers">ФИО курьера</label>
			<select id="couriers" name="couriers">
				<?php
				if (isset($couriers)) {
					echo "<option value=0></option>";
					foreach ($couriers as $key => $val) {
						echo "<option value=" . $key . ">" . $val . "</option>";
					}
				} else {
					echo "<option value=null>список курьеров не загружен</option>";
				}
				?>
			</select>
			<br><br>
			<label for="date_arrival">Дата прибытия в регион</label>
			<label id="date_arrival">???</label>
			<br><br>

			<input type="submit" value="Добавить" onclick="return onSubmit1();">
		</form>
	</div>
	<div>
		<h1>Расписание поездок</h1>
		<form id="form2">
			<label for="date_start">Начало периода</label>
			<input type="date" id="date_start" name="date_start" onchange="onDateSelect();"/>
			<label for="date_stop">Конец периода</label>
			<input type="date" id="date_stop" name="date_stop" onchange="onDateSelect();"/>
			<br>
			<table id="trips_table" name="trip_table">
				<tr>
					<td></td>
				</tr>
			</table>
			<input type="submit" value="Обновить" onclick="return onSubmit2();">
		</form>
	</div>
</body>
</html>