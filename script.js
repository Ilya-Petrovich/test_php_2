let couriers;
let regions;
let trips;

window.onload = function () {
	const myDate = document.getElementById("date_departure");
	const today = new Date();
	myDate.value = today.toISOString().slice(0, 10);
	myDate.min = today.toISOString().slice(0, 10);

	let startDate = document.getElementById("date_start");
	startDate.value = today.toISOString().slice(0, 10);
	// startDate.min = today.toISOString().slice(0, 10);

	let stopDate = document.getElementById("date_stop");
	stopDate.value = today.toISOString().slice(0, 10);
	stopDate.min = startDate.value;
	// function sortOptions(select) {
	// 	var items = [...select.querySelectorAll("option")];
	// 	items.sort((a, b) => a.text == b.text ? 0 : a.text < b.text ? -1 : 1);
	// 	items.forEach(item => select.appendChild(item));
	// }

	// sortOptions(document.getElementById('regions'));
	fetch("./api.php")
		.then(res => res.json())
		.then(data => regions = data);
	fetch("./load_trips.php")
		.then(res => res.json())
		.then(data => trips = data);
};


function onSelect() {
	let id = document.getElementById("regions").value;
	let departure_date = new Date(document.getElementById("date_departure").value);
	let arrival_date = new Date(document.getElementById("date_departure").value);
	Date(arrival_date.setDate(departure_date.getDate() + Number(regions[id][1])));
	arrival_date = arrival_date.getDate() + '.' + (arrival_date.getMonth() + 1) + '.' + arrival_date.getFullYear();
	// console.log(regions[id]);
	// console.log(id);
	// console.log(departure_date);
	// console.log(arrival_date);
	document.getElementById("date_arrival").textContent = arrival_date;

	// console.log(Date(departure_date.setDate(departure_date.getDate())));
	// console.log(Number(regions[id][1]) * 24);
};

function onDateSelect() {
	let startDate = document.getElementById("date_start");
	let stopDate = document.getElementById("date_stop");

	stopDate.min = startDate.value;

	if (stopDate.value < startDate.value) {
		stopDate.value = startDate.value;
	}
};

function onSubmit() {
	let elements = document.getElementById("form1").elements;
	var obj = {};
	for (var i = 0 ; i < elements.length ; i++) {
		var item = elements.item(i);
		obj[item.name] = item.value;
	}
	// e.preventDefault();
 //  const formData = new FormData(e.target);
 //  const formProps = Object.fromEntries(formData);

	console.log(obj);
}

function onSubmit2() {
	fetch("./load_trips.php")
		.then(res => res.json())
		.then(data => trips = data);
	console.log(trips);
	let table = document.getElementById("trip_table");
	table.innerHTML = "<tbody><tr><td>" +
		trips[1] +
		"</td></tr></tbody>";

	console.log(table);
	return false;
}