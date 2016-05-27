<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="intro-text">
                  <span class="name">Salut !</span>
                  <span class="desc">Saisissez votre identifiant et votre mot de passe ! :)</span>
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
            <form method="post" action="<?=Router::$ROOT?>signin/valid">
              <div class="form-group">
                <input type="login" name="login" class="form-control" id="login" placeholder="login ou email">
              </div>
              <div class="form-group">
                <input type="password" name="password" class="form-control" id="password" placeholder="mot de passe">
              </div>
              <div class="form-group">
                <div class="g-recaptcha" data-sitekey="6Lcw9SATAAAAAM3zdE31DuiI9UNcMWCtK9bFdCL9"></div>
              </div>
              <button type="submit" class="btn btn-default">C'est moi !</button>
            </form>
          </div>
      </div>
  </div>
</section>
