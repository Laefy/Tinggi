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
    <div class="col-lg-12">
        <div class="intro-text">
          <span class="name">TOP TINGGI</span>
          <span class="desc">Hum... des classements !</span>
        </div>
    </div>
    <div class="col-xs-10 col-xs-offset-1">
      <?php foreach ($users as $user) { ?>
        <div class="media">
          <div class="media-left">
            <a href="#">
              <img class="media-object" src="<?= $user->img ?>" alt="">
            </a>
          </div>
          <div class="media-body">
            <h6 class="media-heading"><?= $user->login ?></h6>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="col-lg-12">
        <div class="intro-text">
          <span class="name">VOS PUBLICATIONS</span>
          <span class="desc">Pour les voir et les revoirs !</span>
        </div>
    </div>
    <div class="col-xs-10 col-xs-offset-1">
      <?php foreach ($posts as $post) { ?>
      <a href="#" class="thumbnail">
        <?php include 'view/match.post.view.php';?>
      </a>
      <?php } ?>
    </div>
  </div>
</section>
