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
          <div class="col-md-4 col-md-offset-4">
            <form method="post" action="signin/valid">
              <div class="form-group">
                <input type="login" name="login" class="form-control" id="login" placeholder="email">
              </div>
              <div class="form-group">
                <input type="password" name="password" class="form-control" id="password" placeholder="mot de passe">
              </div>
              <button type="submit" class="btn btn-default">C'est moi !</button>
            </form>
          </div>
      </div>
  </div>
</section>
