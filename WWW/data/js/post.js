function addComment(element) {
	var id = 0;//TODO

	var action = function(response) {
		var comment = JSON.parse(response);
		// Afficher un nouveau commentaire en utilisant le contenu de comment.
	}

	postRequest('post/comment/' + id, action,  "comment=element.value");
}