<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="intro-text">
                  <span class="name"><?= $data['title'] ?></span>
                  <span class="desc"><?= $data['description'] ?></span>
                </div>
            </div>
        </div>
    </div>
</header>
<section id="view" class="container-fluid">
  <div class="container-fluid">
      <div class="row">
          <?php self::render_errors($data); ?>
          <div class="col-md-4 col-md-offset-4 text-center">
            <form method="post" action="<?=Router::$ROOT.$data['check']?>" enctype="multipart/form-data">
              <div class="form-group">
                <input type="login" name="login" class="form-control" id="login" placeholder="pseudo" value="<?= \Accessor::post('login','string') ?>">
              </div>
              <div class="form-group">
                <input type="email" name="email" class="form-control" id="email" placeholder="email" value="<?= \Accessor::post('email','string') ?>">
              </div>
              <div class="form-group">
                <input type="password" name="password" class="form-control" id="password" placeholder="mot de passe" value="<?= \Accessor::post('password','string') ?>">
              </div>
              <div class="form-group">
                <input type="password" name="verifpassword" class="form-control" id="verifpassword" placeholder="confirmation du mot de passe" value="">
              </div>
              <div class="form-group">
                <label for="img">Choissisez une image de profil (facultatif)</label>
                <input type="file" id="img" name="img">
              </div>
              <div class="form-group">
                <div class="g-recaptcha" data-sitekey="6Lcw9SATAAAAAM3zdE31DuiI9UNcMWCtK9bFdCL9"></div>
              </div>
              <button type="submit" class="btn btn-default"><?= $data['action'] ?></button>
            </form>
          </div>
      </div>
  </div>
</section>
