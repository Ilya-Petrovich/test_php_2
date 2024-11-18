window.onload = function () {
	const myDate = document.getElementById("date_departure");
	const today = new Date();
	myDate.value = today.toISOString().slice(0, 10);
	myDate.min = today.toISOString().slice(0, 10);

	function sortOptions(select) {
		var items = [...select.querySelectorAll("option")];
		items.sort((a, b) => a.text == b.text ? 0 : a.text < b.text ? -1 : 1);
		items.forEach(item => select.appendChild(item));
	}

	sortOptions(document.getElementById('regions'));
};