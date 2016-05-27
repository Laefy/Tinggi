<header>
    <div class="container">
        <div class="row">
          <div id="all_like">
            <img src="../data/img/crown.png" alt="Match" class="crown"></img>
            <div class="all_like"><?= $data['post']->getScore() ?></div>
          </div>
            <div class="col-lg-12">
                <div class="intro-text">
                  <h4 class="name"><?= $data['post']->getTitle() ?></h4>
                  <strong class="author_post"><?= $data['post']->getAuthor()->getLogin()?></strong><?=', '.$data['post']->getTime().' '?><br />
                  <span class="desc"><?= \controller\PostController::makeExplainedBaliseFromDesc($data['post']->getDesc()) ?></span>
                </div>

                <div class="row">
                  <div class="col-md-6 col-md-offset-3 post-like">
                    <div class="like">
                      <div class="nblike" id="js-likes"><?=$data['post']->getLikes()?></div>
                    </div>
                    <a class="like" id="js-like-trigger" data-id="<?=$data['post']->getId()?>">
                      <div class="like_hover">
                        <img src="../data/img/jaime_hover.png" alt="J'aime"></img>
                      </div>
                      <div class="like_hover_before">
                        <img src="../data/img/jaime_blanc.png" alt="J'aime"></img>
                      </div>
                    </a>
                    <div class="like">
                      <div class="nbdislike" id="js-dislikes"><?=$data['post']->getDislikes()?></div>
                    </div>
                    <a class="like" id="js-dislike-trigger" data-id="<?=$data['post']->getId()?>">
                      <div class="like_hover">
                        <img src="../data/img/jaime_pas_hover.png" alt="J'aime pas" class="like_grey"></img>
                      </div>
                      <div class="like_hover_before">
                        <img src="../data/img/jaime_pas.png" alt="J'aime pas" class="like_white"></img>
                      </div>
                    </a>
                  </div>
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

<script src="<?= \Router::$ROOT ?>data/js/ajax.js"></script>
<script src="<?= \Router::$ROOT ?>data/js/post.js"></script>
