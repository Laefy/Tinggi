function ajaxRequest(url, action) {
	var request = new XMLHttpRequest();
	request.onreadystatechange = function() {
		if (request.readyState == 4 && request.status == 200) {
			action(request.responseText);
		}
	};

	request.open("GET", url, true);
	request.send();
}

function postRequest(url, action, params) {
	var request = new XMLHttpRequest();
	request.onreadystatechange = function() {
		if (request.readyState == 4 && request.status == 200) {
			action(request.responseText);
		}
	};

	request.open("POST", url, true);
	request.send(params);
}