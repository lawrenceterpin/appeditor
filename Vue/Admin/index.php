<?php 
$this->titre = "Administration";

$this->login_actif = $login_actif["login"];

// $login_actif["login"];
?>

<div class="container">
	<div class="row">

		<h2>Administration</h2>
		
		Bienvenue, <?= $this->nettoyer($login) ?> !
		Ce blog comporte <?= $this->nettoyer($nbBillets) ?> billet(s) et <?= $this->nettoyer($nbCommentaires) ?> commentaire(s).
		<br>
		<a id="lienDeco" href="connexion/deconnecter">Se déconnecter</a>

		<br>
		<br>

		<div id="actions-admin">

			<ul class="nav nav-tabs" role="tablist">
			  <li class="active nav-item">
			    <a class="nav-link active" href="#general" role="tab" data-toggle="tab">Général</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" href="#actualites" role="tab" data-toggle="tab">Gérer les actualités</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" href="#utilisateurs" role="tab" data-toggle="tab">Gérer les utilisateurs</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" href="#parametres-compte" role="tab" data-toggle="tab">Paramètres du compte</a>
			  </li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade in active" id="general">
					...
				</div>
			  <div role="tabpanel" class="tab-pane fade" id="actualites">
			  	
			  	<form id="add-actu" action="admin/addBillet" method="post">
						<legend>Ajouter une actualité</legend>

						<label for="example-text-input">Titre</label>
					  <input name="titre" type="text" placeholder="" class="form-control" required autofocus>
					  <br>
					  <label for="example-text-input">Contenu</label>
						<textarea class="form-control" name="contenu" required></textarea>
				    <br>

				    <input type="submit" id="btn-add-actu" class="btn btn-primary" value="Publier l'actualité" />
					</form>
			  </div>
			  <div role="tabpanel" class="tab-pane fade" id="utilisateurs">
			  	<?php 
					foreach ($utilisateurs as $utilisateur):
					?>
					  <article>
					      <header>
					          <a href="">
					              <h1><?= $this->nettoyer($utilisateur['login']) ?></h1>
					          </a>
					      </header>
					  </article>
					  <hr />
					<?php endforeach; ?>
			  </div>
			  <div role="tabpanel" class="tab-pane fade" id="parametres-compte">
			  	
			  </div>
			</div>
		</div>

	</div>
</div>