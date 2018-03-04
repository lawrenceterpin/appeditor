<?php $this->titre = "Paramètres"; ?>

<?php
$dependances_json[] = file_get_contents("Contenu/dependances/dependances.json");

include_once('get_file.php');
?>

<div class="container-fluid">
	<div class="row">

		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $this->titre; ?></h1>
			
			<div id="actions">

				<ul class="nav nav-tabs" role="tablist">
				  <li class="active nav-item">
				    <a class="nav-link active" href="#general" role="tab" data-toggle="tab">Général</a>
				  </li>
				  <li class="nav-item">
				    <a class="nav-link" href="#fonctions" role="tab" data-toggle="tab">Fonctions</a>
				  </li>
				  <li class="nav-item">
				    <a class="nav-link" href="#dependances" role="tab" data-toggle="tab">Dépendances</a>
				  </li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
				  <div role="tabpanel" class="tab-pane fade in active" id="general">...</div>

				  <div role="tabpanel" class="tab-pane fade" id="fonctions">
				  	<div class="col-lg-12">
					  	<form id="form-fonctions" method="post" action="">
						    <input type="text" name="name-fonction" class="form-control" placeholder="Nom de la fonction">
						    <input type="submit" name="add-fonction" id="add-fonction" class="btn btn-defeult" value="Créer la fonction" />
					    </form>
					    <br>
				  		<!-- <div class="col-lg-6"> -->
								<b>Fichier functions.js</b>

								<div id="results-ajax">
									<?php 
									echo "<pre><code>".file_get_contents("Contenu/js/functions.js")."</code></pre>";
									?>
								</div>
							<!-- </div> -->
				    </div>
				  </div>

				  <div role="tabpanel" class="tab-pane fade" id="dependances">
				  	<div class="col-lg-12">
				  		<form id="form-dependances" method="post" action="">
				  			<label><b>Dépendances Javascript actives :</b></label>
				  			<ul>
				  				<?php
									foreach ($dependances_json as $string) {

										$array_dependances = $string;

										$array_files_js = json_decode($string, true)["files_js"];

										foreach($array_files_js as $dependance => $value) {

											echo '<li>'.$value.'</li>';
										}
									}
									?>
				  			</ul>
				  			<label for="list-dependances-js"><b>Ajouter une dépendance Javascript :</b></label>
				  			<select id="list-dependances-js" name="list-dependances-js" class="form-control">
				  				<option value="0" selected="">Sélectionnez une dépendance</option>
				  				<?php
				  				if ($handle = opendir('Contenu/js/')) {

				  					echo '<optgroup label="js">';

								    while (false !== ($entry = readdir($handle))) {

							        if ($entry != "." && $entry != "..") {

							          echo '<option value="js/'.$entry.'">'.$entry.'</option>';
							        }
								    }

								    echo '</optgroup>';

								    closedir($handle);
									}

									if ($handle = opendir('Contenu/bootstrap/js/')) {

										echo '<optgroup label="bootstrap/js">';

								    while (false !== ($entry = readdir($handle))) {

							        if ($entry != "." && $entry != "..") {

							          echo '<option value="bootstrap/js/'.$entry.'">'.$entry.'</option>';
							        }
								    }

								    echo '</optgroup>';

								    closedir($handle);
									}
				  				?>
				  			</select>
				  			<br>
				  			<label><b>Dépendances CSS actives :</b></label>
				  			<ul>
				  				<?php
									foreach ($dependances_json as $string) {

										$array_dependances = $string;

										$array_files_css = json_decode($string, true)["files_css"];

										foreach($array_files_css as $dependance => $value) {

											echo '<li>'.$value.'</li>';
										}
									}
									?>
				  			</ul>
				  			<label for="list-dependances-css"><b>Ajouter une dépendance CSS :</b></label>
				  			<select id="list-dependances-css" name="list-dependances-css" class="form-control">
				  				<option value="0" selected="">Sélectionnez une dépendance</option>
				  				<?php
				  				if ($handle = opendir('Contenu/css/')) {

				  					echo '<optgroup label="css">';

								    while (false !== ($entry = readdir($handle))) {

							        if ($entry != "." && $entry != "..") {

							          echo '<option value="css/'.$entry.'">'.$entry.'</option>';
							        }
								    }

								    echo '</optgroup>';

								    closedir($handle);
									}

									if ($handle = opendir('Contenu/bootstrap/css/')) {

										echo '<optgroup label="bootstrap/css">';

								    while (false !== ($entry = readdir($handle))) {

							        if ($entry != "." && $entry != "..") {

							          echo '<option value="Contenu/bootstrap/css/'.$entry.'">'.$entry.'</option>';
							        }
								    }

								    echo '</optgroup>';

								    closedir($handle);
									}
				  				?>
				  			</select>
				  			<input type="submit" name="add-dependance" id="add-dependance" class="btn btn-default" value="Ajouter la dépendance" />
				  		</form>

				  		<b>Fichier dependances.json</b>
							<?php
							foreach ($dependances_json as $string) {

								$array_dependances = $string;

								echo "<pre><code>";
									var_dump($array_dependances);
								echo "</code></pre>";
							}
							?>
				  	</div>
				  </div>
				</div>
			</div>
		</div>
	</div>
</div>