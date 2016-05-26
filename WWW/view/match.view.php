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
        <a href="#" class="thumbnail">
          <?php
            $post = $data['post1'];
            include 'view/match.post.view.php';
          ?>
        </a>
      </div>
      <div class="col-md-6">
        <a href="#" class="thumbnail">
          <?php
            $post = $data['post2'];
            include 'view/match.post.view.php';
          ?>
        </a>
      </div>
    </div>
  </div>
</section>
