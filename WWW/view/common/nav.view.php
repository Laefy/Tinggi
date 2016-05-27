<nav class="navbar navbar-tinggi navbar-fixed-top">
    <div class="container">
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?=Router::$ROOT?>"><img src="<?=Router::$ROOT?>data/img/<?=controller\UserController::getLogo()?>.svg" height="80" width="80" alt="logo" class="img-responsive center-block"></img>Tinggy</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="page-scroll">
                    <a href="<?= \Router::$ROOT ?>">Match</a>
                </li>
                <li class="page-scroll">
                    <a href="<?= \Router::$ROOT."top" ?>">Top</a>
                </li>
                <?php
                  if(!\Session::isLogin()){
                    echo '<li class="page-scroll"><a href="',\Router::$ROOT,'signup">Inscription</a></li>
                          <li class="page-scroll"><a href="',\Router::$ROOT,'signin">Connexion</a></li>';
                  }
                  else
                  {
                    echo '<li class="page-scroll"><a href="',\Router::$ROOT,'post/new">Nouveau</a></li>
                          <li class="page-scroll"><a href="',\Router::$ROOT,'user/board">Tableau</a></li>
                          <li class="page-scroll"><a href="',\Router::$ROOT,'user/',\Session::getUser()->getLogin(),'">Compte</a></li>
                          <li class="page-scroll"><a href="',\Router::$ROOT,'signout">Deconnexion</a></li>';
                  }
                ?>
            </ul>
        </div>
    </div>
</nav>
