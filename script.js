let couriers;
let regions;
let trips;

window.onload = function () {
	document.getElementById("form1").reset();
	const myDate = document.getElementById("date_departure");
	const today = new Date();
	myDate.value = today.toISOString().slice(0, 10);
	myDate.min = today.toISOString().slice(0, 10);

	let startDate = document.getElementById("date_start");
	startDate.value = today.toISOString().slice(0, 10);

	let stopDate = document.getElementById("date_stop");
	stopDate.value = today.toISOString().slice(0, 10);
	stopDate.min = startDate.value;

	fetch("./api.php")
		.then(res => res.json())
		.then(data => regions = Object.values(data));
	fetch("./load_trips.php")
		.then(res => res.json())
		.then(data => trips = Object.values(data));
	fetch("./load_couriers.php")
		.then(res => res.json())
		.then(data => couriers = Object.values(data));
};

function onSelect() {
	let id = document.getElementById("regions").value;
	let departure_date = new Date(document.getElementById("date_departure").value);
	let arrival_date = new Date(document.getElementById("date_departure").value);
	let n = regions.find((item) => item[0] == id)[0];
	Date(arrival_date.setDate(departure_date.getDate() + Number(n)));
	arrival_date = arrival_date.getDate() + '.' + (arrival_date.getMonth() + 1) + '.' + arrival_date.getFullYear();
	document.getElementById("date_arrival").textContent = arrival_date;
};

function onDateSelect() {
	let startDate = document.getElementById("date_start");
	let stopDate = document.getElementById("date_stop");

	stopDate.min = startDate.value;

	if (stopDate.value < startDate.value) {
		stopDate.value = startDate.value;
	}
};

function onSubmit1() {
	let elements = document.getElementById("form1").elements;
	var obj = {};
	for (var i = 0 ; i < elements.length ; i++) {
		var item = elements.item(i);
		obj[item.name] = item.value;
	}
	let arr_date = new Date(document.getElementById("date_arrival").textContent);

	let id = document.getElementById("regions").value;
	let departure_date = new Date(document.getElementById("date_departure").value);
	let arrival_date = new Date(document.getElementById("date_departure").value);
	let n = regions.find((item) => item[0] == id)[0];
	Date(arrival_date.setDate(departure_date.getDate() + Number(n)));
	arrival_date = arrival_date.getFullYear() + '-' + (arrival_date.getMonth() + 1) + '-' + arrival_date.getDate();

	for (var el in trips) {
		let c = couriers.find((item) => item[0] == trips[el][1]);
		let departure_date = document.getElementById("date_departure").value;
		if (trips[el][1] == obj.couriers &&
			(departure_date >= trips[el][3] && departure_date <= trips[el][4] ||
			arrival_date >= trips[el][3] && arrival_date <= trips[el][4])) {
			console.log("wrong ");
			alert("В выбранный период курьер занят!");
			return false;
		}
	}

	if (obj.regions != "0" && obj.couriers != "0") {
		fetch("./add_entry.php?courier_id=" + obj.couriers +
			"&region_id=" + obj.regions +
			"&departure_date=" + obj.date_departure +
			"&arrival_date=" + arrival_date)
			.then((res) => {
				if (res.statusText == "OK") {
					alert("Поездка добавлена!");
				}
			});
	}

	return false;
}

function onSubmit2() {
	let startDate = document.getElementById("date_start");
	let stopDate = document.getElementById("date_stop");

	fetch("./load_trips.php")
		.then(res => res.json())
		.then(data => trips = Object.values(data))
		.then((res) => {
			let table = document.getElementById("trips_table");
			html = "<tbody>";

			for (var el in trips) {
				let c = couriers.find((item) => item[0] == trips[el][1]);
				let r = regions.find((item) => item[0] == trips[el][2]);
				if (startDate.value <= trips[el][3] && stopDate.value >= trips[el][3] ||
					startDate.value <= trips[el][4] && stopDate.value >= trips[el][4] ||
					startDate.value >= trips[el][3] && stopDate.value <= trips[el][4]) {
					html += "<tr><td>" + c[1] + " " + c[2] + " " + c[3] + "</td><td>";
					html += r[1] + "</td><td>" + trips[el][3].slice(-2) + "." +
					trips[el][3].slice(-5, -3) + "." + trips[el][3].slice(0, -6) +
					"</td><td>" +	trips[el][4].slice(-2) + "." +
					trips[el][4].slice(-5, -3) + "." + trips[el][4].slice(0, -6) +
					"</td></tr>";
				}
			}

			html += "</tbody>";
			table.innerHTML = html;
		});

	return false;
}