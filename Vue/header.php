<header id="navbar" role="banner" class="navbar">
  <nav class="navbar navbar-fixed-top navbar-shrink">
    <div class="container-fluid">
      <div class="col-lg-12">
    	<!-- <div class="row"> -->
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">MENU</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <h1>
            	<a class="logo navbar-btn navbar-brand" href="/appeditor" title="Retour à l'accueil">
            		<span class="fa fa-th"></span>
            		App Editor
            	</a>
            </h1>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul id="menu" class="nav navbar-nav navbar-right">
            <!-- <li>
              <div id="compteur-notif">
                <a href="utilisateurs" title="Nombre d'utilisateurs en ligne">
                  <span class="glyphicon glyphicon-user"></span><span id="nb-user-actif"></span>
                </a>
              </div>
            </li> -->
            <!-- <li class="hidden active">
                <a href="#page-top"></a>
            </li> -->
            <!-- <li class="accueil">
              <a href="accueil" title="Page d'accueil"><span class="glyphicon glyphicon-home"></span><span class="hidden">&nbsp;&nbsp;Accueil</span></a>
            </li> -->
            <li>
              <a href="manage" title="Créer ou modifier une application"><span class="glyphicon glyphicon-wrench"></span>&nbsp;&nbsp;Editeur d'applications</a>
            </li>
            <li>
              <a href="parametres"><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;Paramètres</a>
            </li>
            <li>
              <a href="billets"><span class="glyphicon glyphicon-globe"></span>&nbsp;&nbsp;Actualités</a>
            </li>
            <?php
            if( isset($login_actif) ) {
            ?>
              <li class="admin">
                <a href="admin" title="Accéder à mon profil"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?php echo $login_actif; ?></a>
              </li>
              <li>
                <a href="connexion/deconnecter"><span class="glyphicon glyphicon-off"></span>Se déconnecter</a>
              </li>
            <?php
          	}
            else {
              ?>
              <li>
                <a href="connexion"><span class="glyphicon glyphicon-off"></span>Se connecter</a>
              </li>
              <?php
            }
            ?>
          </ul>
        </div>
      <!-- </div> -->
      </div>
      <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
  </nav>
</header>