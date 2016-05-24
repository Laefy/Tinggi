function checkPasswordField(element) {
	// TODO: check the length, use of alphanumeric characters, etc.
}

function checkLoginField(element) {
	var login = element.value;

	// TODO: check the length, use of legal characters, etc.
	var parameter = '{ "login":' + login + ' }';
	
	var action = function(response) {
		// Call invalid login function.
	}

	ajaxRequest('Post/isLoginExisting/' + parameter, action);
}