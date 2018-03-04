<div class="container">
	<div class="row">
	
		<?php 
		$this->titre = "History book"; 
		?>
		
		<h1 class="page-header">Toutes les actualités</h1>
		
		<section id="view-actualites">
			<h2>Dernières actualités</h2>
			<ul>
				<?php
				foreach ($billets as $billet):
		    ?>
			    <li><article>
			        <header>
		            <a href="<?= "billet/index/" . $this->nettoyer($billet['id']) ?>">
	                <h3 class="titreBillet"><?= $this->nettoyer($billet['titre']) ?></h3>
		            </a>
		            <time>

		            	<?php
		            	$format = 'Y-m-d H:i:s';
									$date = DateTime::createFromFormat($format, $this->nettoyer($billet['date']));
									echo '<i>Publiée le '.$date->format('d/m/Y à H:i:s') . "\n</i>";
		            	?>
		            </time>
			        </header>
			        <br>
			        <p><?= htmlspecialchars_decode($billet['contenu']) ?></p>
				    </article>
				    <hr />
				  </li>
				<?php endforeach; ?>
			</ul>
		</section>
	
	</div>

</div>

