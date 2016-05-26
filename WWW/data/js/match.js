function selectWinner(element) {
	var id = element.getAttribute('data-id');

	var action = function(response) {
		// Animation pour le win ?
		makeNewMatch();
	}

	ajaxRequest('post/winner/' + id, action);
}

function makeNewMatch() {
	var action = function(response) {
		var matchNodes = document.getElementsByClassName('class_match');
		var leftPost = matchNodes[0].children[0];
		var leftImg = matchNodes[0].children[1];
		var rightPost = matchNodes[1].children[0];
		var rightImg = matchNodes[1].children[1];
		
		var data = JSON.parse(response);

		leftPost.innerHTML = '<h3>' + data.title1 + '</h3>' + data.description1;
		rightPost.innerHTML = '<h3>' + data.title2 + '</h3>' + data.description2;
		leftImg.setAttribute('data-category', data.id1);
		rightImg.setAttribute('data-category', data.id2);
	}

	ajaxRequest('post/match/', action);
}

function initMatchView() {
	var elements = document.getElementsByClassName('like_match');
	for (var i = 0; i < elements.length; ++ i) {
		elements[i].onclick = function() {
			selectWinner(this);
		}
	}
}

document.onreadystatechange = function() {
	if (document.readyState == 'interactive') {
		initMatchView();
	}

}