function addComment(element) {
	var id = 0; //TODO.

	var action = function(response) {
		var comment = JSON.parse(response);
		// Afficher un nouveau commentaire en utilisant le contenu de comment.
	}

	postRequest('post/comment/' + id, action,  "comment=element.value");
}

function toggleLike(element) {
	var id = element.getAttribute('data-id');

	var action = function(response) {
		var data = JSON.parse(response);
		var likes = document.getElementById('js-likes');
		var dislikes = document.getElementById('js-dislikes');
		var score = document.getElementById('js-score');

		likes.innerHTML = data.likes;
		dislikes.innerHTML = data.dislikes;
		score.innerHTML = data.score;
	}

	ajaxRequest('like/' + id, action);
}

function toggleDislike(element) {
	var id = element.getAttribute('data-id');

	var action = function(response) {
		var data = JSON.parse(response);
		var likes = document.getElementById('js-likes');
		var dislikes = document.getElementById('js-dislikes');
		var score = document.getElementById('js-score');

		likes.innerHTML = data.likes;
		dislikes.innerHTML = data.dislikes;
		score.innerHTML = data.score;
	} 

	ajaxRequest('dislike/' + id, action);
}

function initPostView() {
	var like = document.getElementById('js-like-trigger');
	like.onclick = function() {
		toggleLike(this);
	};

	var dislike = document.getElementById('js-dislike-trigger');
	dislike.onclick = function() {
		toggleDislike(this);
	};
}

document.onreadystatechange = function() {
	if (document.readyState == 'interactive') {
		initPostView();
	}
}