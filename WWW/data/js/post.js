function addComment(element) {
	var parameter = '{ "comment":' + element.value + ' }';;

	var action = function(response) {
		var comment = JSON.parse(response);
		// Afficher un nouveau commentaire en utilisant le contenu de comment.
	}

	ajaxRequest('Post/addComment/' + parameter, action);
}