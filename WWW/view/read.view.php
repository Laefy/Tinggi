<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="intro-text">
                  <h4 class="name"><?= $data['post']->getTitle() ?></h4>
                  <strong><?= $data['post']->getAuthor()->getLogin().'  -  '.$data['post']->getTime().' '?> <?= $data['post']->getScore() ?></strong><br />
                  <span class="desc"><?= \controller\PostController::makeBaliseFromDesc($data['post']->getDesc()) ?></span>
                </div>
            </div>
        </div>
    </div>
</header>
<section id="view" class="container-fluid">
  <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
      <div class="col-md-8 col-md-offset-2">
        <?php foreach ($data['comments'] as $comment) { ?>
        <div class="media">
          <div class="media-left">
            <a href="#">
              <img class="media-object" height="50" width="50" src="<?= \Router::$ROOT.'data/upload/'.$comment->getAuthor()->getImage() ?>" alt="">
            </a>
          </div>
          <div class="media-body">
            <h6 class="media-heading"><?= $comment->getAuthor()->getLogin().' '.$comment->getTime() ?></h6>
            <?= $comment->getText() ?>
          </div>
        </div>
        <? }
        if (\Session::isLogin()) {
          $user = \Session::getUser();
        ?>
        <div class="media">
          <div class="media-left">
            <a href="#">
              <img class="media-object" height="50" width="50" src="<?= \Router::$ROOT.'data/upload/'.$user->getImage() ?>" alt="">
            </a>
          </div>
          <div class="media-body">
            <h6 class="media-heading"><?= $user->getLogin() ?></h6>
            <div class="form-group">
              <textarea class="form-control"></textarea>
            </div>
        <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<a href="<?= \Router::$ROOT ?>post/new">
  <img src="<?=\Router::$ROOT?>data/img/crosse.png" alt="croix" id="crosse"></img>
</a>
