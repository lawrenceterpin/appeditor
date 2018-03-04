<?php $this->titre = "Connexion" ?>

<div class="container">
	<div class="row">

		<?php
		if( isset($login_actif) ) {
			?>

			<p>
				<b><?php echo $login_actif;?></b>, vous êtes déja connecté
				<a href="admin" title="Accéder à ma page de profil">Voir mon profil</a>
			</p>

			<?php
		}
		else {
		?>
		
			<form id="connexion" action="connexion/connecter" method="post">
					<legend>Connexion</legend>
					<div class="alert alert-warning">
						<p>Vous devez être connecté pour accéder à l'application</p>
					</div>
					<div class="form-group">
						<label for="login" class="col-2 col-form-label">Login</label>
		  			<div class="col-10">
				   	  <input name="login" id="login" type="text" placeholder="Entrez votre login" class="form-control" required autofocus>
				   	</div>
			    </div>
			    <div class="form-group">
				    <label for="password" class="col-2 col-form-label">Mot de passe</label>
		  			<div class="col-10">
					    <input name="mdp" id="password" type="password" placeholder="Entrez votre mot de passe" class="form-control" required>
					  </div>
					</div>
			    <br>
			    <button id="btn-connexion" type="submit" class="btn btn-primary">Connexion</button>
			</form>
		
		<?php
		}

		if (isset($msgErreur)): ?>
		    <p><?= $msgErreur ?></p>
		<?php endif; ?>
	
	</div>
</div>