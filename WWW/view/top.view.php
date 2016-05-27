<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="intro-text">
                  <span class="name">TOP DU LOL</span>
                  <span class="desc">Les meilleurs quoi !</span>
                </div>
            </div>
        </div>
    </div>
</header>
<section id="view" class="container-fluid">
  <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
      <?php foreach ($data['posts'] as $post) { ?>
      <a href="<?=\Router::$ROOT.'post/'.$post->getId()?>" class="thumbnail">
        <?php include \Router::$WEBROOT.'view/match.post.view.php';?>
      </a>
      <?php } ?>
    </div>
  </div>
</section>
<a href="<?= \Router::$ROOT ?>post/new">
  <img src="<?=\Router::$ROOT?>data/img/crosse.png" alt="croix" id="crosse"></img>
</a>
