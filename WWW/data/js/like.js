function toggleLike(element) {
	var id = element.getAttribute('data-id');
	var parameter = '{ "id":' + id + ' }';

	var action = function(response) {
		// Upgrade number of like in the view.
	} 

	ajaxRequest('Post/toggleLike/' + parameter, action);
}

function toggleDislike(element) {
	var id = element.getAttribute('data-id');
	var parameter = '{ "id":' + id + ' }';

	var action = function(response) {
		// Upgrade number of dislike in the view.
	} 

	ajaxRequest('Post/toggleDislike/' + parameter, action);
}