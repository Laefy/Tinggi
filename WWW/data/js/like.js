function toggleLike(element) {
	var id = element.getAttribute('data-id');

	var action = function(response) {
		// Upgrade number of like in the view.
	} 

	ajaxRequest('Post/toggleLike/' + id, action);
}

function toggleDislike(element) {
	var id = element.getAttribute('data-id');

	var action = function(response) {
		// Upgrade number of dislike in the view.
	} 

	ajaxRequest('Post/toggleDislike/' + id, action);
}