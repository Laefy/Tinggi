<nav class="navbar navbar-tinggi navbar-fixed-top">
    <div class="container">
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#page-top">Tinggi</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="page-scroll">
                    <a href="match">Match</a>
                </li>
                <li class="page-scroll">
                    <a href="top">Top</a>
                </li>
                <?php
                  if(is_null($VIEW_user)){
                    echo '<li class="page-scroll">
                        <a href="signup">Inscription</a>
                    </li>
                    <li class="page-scroll">
                        <a href="signin">Connexion</a>
                    </li>';
                  }
                  else{
                    echo '<li class="page-scroll">
                        <a href="user/',$pseudo,'">Compte</a>
                    </li>
                    <li class="page-scroll">
                        <a href="signout">Deconnexion</a>
                    </li>';
                  }
                ?>
            </ul>
        </div>
    </div>
</nav>
