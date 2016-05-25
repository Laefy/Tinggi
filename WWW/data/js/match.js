function selectWinner(element) {
	var id = element.getAttribute('data-id');

	var action = function(response) {
		// Animation pour le win ?

		generateNewMatch();
	}

	ajaxRequest('Post/selectWinner/' + id, action);
}

function makeNewMatch() {
	var action = function(response) {
		// Parser la réponse pour afficher les deux nouveaux posts.
	}

	ajaxRequest('Post/makeNewMatch/', action);
}