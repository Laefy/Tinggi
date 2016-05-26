 <header>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="intro-text">
					<span class="name">MATCH UP</span>
					<span class="desc">VS</span>
				</div>
			</div>
		</div>
	</div>
</header>
<section id="view" class="container-fluid">
  <div class="row">
	<div class="col-xs-10 col-xs-offset-1">
	  <div class="col-md-6">
		<a href="#" class="thumbnail  left">
		  <div class="class_match">
        <?php
          $post = $data['post1'];
          include \Router::$WEBROOT.'view/match.post.view.php';
        ?>
		  </div>
		</a>
		<div class="media">
			<div class="like left">
				<div class="like_hover">
					<img class="img-responsive like" src="data/img/jaime_hover.png" alt="image">
				</div>
				<div class="like_before_hover">
					<img class="img-responsive like" src="data/img/jaime_blanc.png" alt="image">
				</div>
			</div>
		</div>
		<div class="description left">
			<p>description</p>
		</div>
		<div class="commentaire left">
			<p>+ Commentaires</p>
		</div>
	  </div>
	  <div class="col-md-6">
		<a href="#" class="thumbnail">
			<div class="class_match ">
        <?php
          $post = $data['post2'];
          include \Router::$WEBROOT.'view/match.post.view.php';
        ?>
			</div>
		</a>
		<div class="media">

			<div class="like">
				<div class="like_hover">
					<img class="img-responsive like" src="<?= \Router::$ROOT ?>data/img/jaime_hover.png" alt="image">
				</div>
				<div class="like_before_hover">
					<img class="img-responsive like" src="<?= \Router::$ROOT ?>data/img/jaime_blanc.png" alt="image">
				</div>
			</div>

		</div>
		<div class="description">
			<p>description</p>
		</div>
		<div class="commentaire">
			<p>+ Commentaires</p>
		</div>
	  </div>
	</div>
  </div>
</section>
<a href="post/new">
<img src="<?= \Router::$ROOT ?>data/img/crosse.png" alt="croix" id="crosse"></img>
</a>
