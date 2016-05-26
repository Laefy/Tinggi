<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="intro-text">
                  <span class="name">Modifier ou S'inscrire</span>
                  <span class="desc">un message cool ! :)</span>
                </div>
            </div>
        </div>
    </div>
</header>
<section id="view" class="container-fluid">
  <div class="container-fluid">
      <div class="row">
          <div class="col-md-4 col-md-offset-4">
            <?php if($data['error']) { ?>
              <div class="alert alert-warning"><strong>Erreur ! :'(</strong><ul><?php foreach ($datas['errors'] as $string) { '<li>'.$string.'</li>' } ?></ul></div>
            <?php } ?>
            <form method="post" action="signup/new">
              <div class="form-group">
                <input type="login" name="login" class="form-control" id="login" placeholder="pseudo" value="<?= \Accessor::post('login') ?>">
              </div>
              <div class="form-group">
                <input type="email" name="email" class="form-control" id="email" placeholder="email" value="<?= \Accessor::post('email') ?>">
              </div>
              <div class="form-group">
                <input type="password" name="password" class="form-control" id="password" placeholder="mot de passe" value="<?= \Accessor::post('password') ?>">
              </div>
              <div class="form-group">
                <input type="vpassword" name="verifpassword" class="form-control" id="verifpassword" placeholder="confirmation du mot de passe" value="<?= \Accessor::post('verifpassword') ?>">
              </div>
              <div class="form-group">
                <label for="img">Choissisez une image de profil</label>
                <input type="file" id="img">
              </div>
              <button type="submit" class="btn btn-default">C'est moi !</button>
            </form>
          </div>
      </div>
  </div>
</section>
