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
    <div class="col-md-6 text-center match">
      <a href="#" class="thumbnail  left">
        <div class="class_match" id="js-match-left-post">
          <?php
          $post = $data['post1'];
          include \Router::$WEBROOT.'view/match.post.view.php';
          ?>
        </div>
      </a>
      <a class="btn btn-default btn-match" href="<?= \Router::$ROOT.'post/'.$post->getId() ?>" role="button">Détails</a>
    </div>
    <div class="col-md-6 text-center match">
      <a href="#" class="thumbnail">
        <div class="class_match ">
          <?php
          $post = $data['post2'];
          include \Router::$WEBROOT.'view/match.post.view.php';
          ?>
        </div>
      </a>
      <a class="btn btn-default btn-match" href="<?= \Router::$ROOT.'post/'.$post->getId() ?>" role="button">Détails</a>
    </div>
  </div>
</div>
</section>
<a href="<?= \Router::$ROOT ?>post/new">
  <img src="<?= \Router::$ROOT ?>data/img/crosse.png" alt="croix" id="crosse"></img>
</a>

<script src="data/js/ajax.js"></script>
<script src="data/js/match.js"></script>
