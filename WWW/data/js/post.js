function addComment(element) {
	var action = function(response) {
		var comment = JSON.parse(response);
		// Afficher un nouveau commentaire en utilisant le contenu de comment.
	}

	postRequest('Post/addComment/', action,  "comment=element.value");
}