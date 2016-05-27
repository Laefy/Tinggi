<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="intro-text">
                  <span class="name"><?=$data->getTitle()?></span>
                  <span class="desc"><?=$data->getDesc()?></span>
                </div>
            </div>
        </div>
    </div>
</header>
<section id="view" class="container-fluid">
  <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
      <div class="col-md-8 col-md-offset-2">
        <?php
          foreach ($data->getComments() as $comment) {
            echo '<div class="media">
              <div class="media-left">
                <a href="#">
                  <!--<img class="media-object" src="..." alt="...">-->
                </a>
              </div>
              <div class="media-body">
                <h6 class="media-heading">' .$comment->getAuthor()->getLogin(). '</h6>
                ' .$comment->getText(). '
              </div>
            </div>';
          }
        ?>
        <div class="media">
          <div class="media-left">
            <a href="#">
              <!--<img class="media-object" src="..." alt="...">-->
            </a>
          </div>
          <div class="media-body">
            <h6 class="media-heading">moi</h6>
            <div class="form-group">
              <textarea class="form-control"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<a href="post/new">
  <img src="<?=\Router::$ROOT?>data/img/crosse.png" alt="croix" id="crosse"></img>
</a>
