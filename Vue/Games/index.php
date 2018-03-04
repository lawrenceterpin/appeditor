<?php $this->titre = "Games"; ?>

<div class="container">
	<div class="row">
		
		<?php foreach ($games as $game):
		    ?>
		    <article>
		        <header>
		            <a href="<?= "game/index/" . $this->nettoyer($game['id']) ?>">
		                <h1 class="titreGame"><?= $this->nettoyer($game['titre']) ?></h1>
		            </a>
		            <time><?= $this->nettoyer($game['date']) ?></time>
		        </header>
		        <p><?= $this->nettoyer($game['contenu']) ?></p>
		    </article>
		    <hr />
		<?php endforeach; ?>
	
	</div>

</div>