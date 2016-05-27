<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="intro-text">
                  <span class="name">Le Dashboard</span>
                  <span class="desc">Un super tableau de bord !</span>
                </div>
            </div>
        </div>
    </div>
</header>
<section id="view" class="container-fluid">
  <div class="row">
    <div class="col-lg-12 text-center">
        <div class="intro-text">
          <span class="name">TOP TINGGY</span>
          <span class="desc">Hum... des classements !</span>
        </div>
    </div>
    <div class="col-xs-4 col-xs-offset-4 text-center">
      <?php $i=0;
      foreach ($data['users'] as $user) { ?>

        <div class="media">
          <div class="media-left">
            <a href="#">
              <img class="media-object" height="50" width="50" src="<?= \Router::$ROOT.'data/upload/'.$user->getImage() ?>" alt="">
            </a>
          </div>
          <div class="media-body">
            <h6 class="media-heading"><?= ++$i.' - '.$user->getLogin() ?></h6>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="col-lg-12 text-center">
        <div class="intro-text">
          <span class="name">VOS PUBLICATIONS</span>
          <span class="desc">Pour les voir et les revoir !</span>
        </div>
    </div>
    <div class="col-xs-10 col-xs-offset-1 text-center">
      <?php
      if(empty($data['posts']))
      {
        echo 'aucune publication !';
      }
      foreach ($data['posts'] as $post) { ?>
      <a href="<?=\Router::$ROOT.'post/'.$post->getId()?>" class="thumbnail">
        <?php include \Router::$WEBROOT.'view/match.post.view.php';?>
      </a>
      <?php } ?>
    </div>
  </div>
</section>
<a href="<?= \Router::$ROOT ?>post/new">
  <img src="<?= \Router::$ROOT ?>data/img/crosse.png" alt="croix" id="crosse"></img>
</a>
