function selectWinner(element) {
	var id = element.getAttribute('data-id');
	var parameter = '{ "id":' + id + ' }';

	var action = function(response) {
		// Animation pour le win ?

		generateNewMatch();
	}

	ajaxRequest('Post/selectWinner/' + parameter, action);
}

function generateNewMatch() {
	var action = function(response) {
		// Parser la réponse pour afficher les deux nouveaux posts.
	}

	ajaxRequest('Post/makeNewMatch/', action);
}