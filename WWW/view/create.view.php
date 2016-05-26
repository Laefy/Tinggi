<header>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="intro-text">
				  <span class="name">Poster un contenu</span>
				  <span class="desc">un message cool ! :)</span>
				</div>
			</div>
		</div>
	</div>
</header>
<section id="view" class="container-fluid">
  <div class="container-fluid">
	  <div class="row">
		  <div class="col-md-4 col-md-offset-4">
				<?php if($data['error']) { ?>
					<div class="alert alert-warning"><strong>Erreur ! :'(</strong><ul><?php foreach ($data['errors'] as $string) { ?><li><?= $string ?></li><?php } ?></ul></div>
				<?php } ?>
					<form method="post" action="<?=Router::$ROOT?>post/send">
				  <div class="form-group">
					<label for="title" class="post_int">Écris ton titre</label>
					<input type="text" class="form-control" name="title" placeholder="Ton titre" value="<?= \Accesor::post('title','string'); ?>">
				  </div>
				  <div class="form-group">
					<label for="url" class="post_int">Note le lien de ta vidéo OU de ta photo</label>
					<input type="text" class="form-control" name="url" placeholder="Url" value="<?= \Accesor::post('url','string'); ?>">
				  </div>
				  <div class="form-group">
					<label for="description" class="post_int">Écris ton  message</label>
					<textarea type="text" class="form-control" name="description" value="<?= \Accesor::post('description','string'); ?>">
					</textarea>
				  </div>
				  <button type="submit" class="btn btn-default">C'est moi !</button>
				</form>
		  </div>
	  </div>
  </div>
</section>
