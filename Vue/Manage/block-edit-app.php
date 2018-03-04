<!-- <div id="wrapper-infos-files" class="hidden">
	<ul>
		<?php
		/*foreach ($files as $file) {*/

			/*echo '<li>
							<span class="filename">'.$file['filename'].'</span>
							<span class="fileauteur">'.$file['fileauteur'].'</span>
						</li>';
		}*/
		?>
	</ul>
</div> -->

<ul class="nav nav-tabs" role="tablist">
	<li class="nav-item hidden">
    <a class="nav-link" href="#file-source" role="tab" data-toggle="tab">Editer le fichier</a>
  </li>
  <li class="active nav-item">
    <a class="nav-link" href="#arborescence" role="tab" data-toggle="tab">Arborescence des fichiers</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#folder-file" role="tab" data-toggle="tab">Librairies</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#add-file" role="tab" data-toggle="tab">Ajout de fichiers</a>
  </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade hidden" id="file-source">

  	<form id="form-editeur" method="post" action="">
			<textarea id="code" name="file-edit">contenu</textarea>
			<br>

			<div class="col-sm-6">
				<label for="select-themes">Modifiez le thème de l'éditeur</label>
				<select id="select-themes" class="form-control">

					<option selected>default</option>
					<?php
					if ($handle = opendir('Contenu/codemirror/theme')) {
						while (false !== ($entry = readdir($handle))) {
							if ($entry != "." && $entry != ".." ) {

								$name_file = str_replace('.css', '', $entry);

								echo '<option>'.$name_file.'</option>';
							}
						}
						closedir($handle);
					}
					?>

				</select>

				<textarea name="new-content" class="hidden"></textarea>
				<input type="hidden" name="path-file-editeur" value="/volume1/web/appeditor/Games/projet_1/js/main.js">
			</div>
			<div class="col-sm-6">

				<!-- <label for="path-file-copy">Nom du fichier de sauvegarde</label>
				<input type="text" id="path-file-copy" name="path-file-copy" value="/volume1/web/appeditor/Games/projet_1/js/main-1.js" class="form-control"> -->
				<!-- <br>
				<label class="checkbox-inline">
					<input type="checkbox" value="1" name="copy-file">Sauvegarder ce fichier
				</label> -->
			</div>
			<br>
			<input type="submit" name="update-file-editeur" id="update-file-editeur" value="Enregistrer les modifications" class="btn btn-success">
		</form>

  </div>
  <div role="tabpanel" class="tab-pane fade in active" id="arborescence">
  	<div class="loading-files">
			<img src="Contenu/img/Ripple.gif" class="loading">
		</div>
  	<div id="load-block"></div>
  </div>
  <div role="tabpanel" class="tab-pane fade" id="folder-file">
  	<div class="bs-example">
		  <div class="panel-group" id="accordion">
		    <div class="panel panel-default">
		      <div class="panel-heading">
		        <h4 class="panel-title">
		            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">img/transferts</a>
		        </h4>
		      </div>
		      <div id="collapseOne" class="panel-collapse collapse">
		        <div class="panel-body file-app">

		        	<table class="table">
						    <thead>
						      <tr>
						        <th>Nom du fichier</th>
						        <th>Aperçu du fichier</th>
						        <th>Sélection</th>
						      </tr>
						    </thead>
						    <tbody>
		              <?php

		              if ($handle = opendir('Games/projet_1/img/transferts')) {

								    while (false !== ($entry = readdir($handle))) {

								        if ($entry != "." && $entry != ".." && $entry != "fonts" && $entry != "shoot-em-up" ) {

								          echo '
								          <tr>
								          	<td>'.$entry.'</td>
								          	<td><img data-src="Games/projet_1/img/transferts/'.$entry.'" class="lazyload img-responsive"/></td>
								          	<td><label><input type="checkbox" name="Games/projet_1/img/transferts/'.$entry.'" value=""></label></td>
								          </tr>';
								        }
								    }

								    closedir($handle);
									}
		              ?>
		            </tbody>
						  </table>
		        </div>
		      </div>
		    </div>
		    <div class="panel panel-default">
		      <div class="panel-heading">
		        <h4 class="panel-title">
		            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">assets</a>
		        </h4>
		      </div>
		      <div id="collapseTwo" class="panel-collapse collapse">
		        <div class="panel-body file-app">

		        	<table class="table">
						    <thead>
						      <tr>
						        <th>Nom du fichier</th>
						        <th>Aperçu du fichier</th>
						        <th>Sélection</th>
						      </tr>
						    </thead>
						    <tbody>
		              <?php
		              if ($handle = opendir('Games/projet_1/assets')) {

								    while (false !== ($entry = readdir($handle))) {

								        if ($entry != "." && $entry != ".." && $entry != "fonts" && $entry != "shoot-em-up" ) {

								          echo '
								          <tr>
								          	<td>'.$entry.'</td>
								          	<td><img data-src="Games/projet_1/assets/'.$entry.'" class="lazyload img-responsive"/></td>
								          	<td><label><input type="checkbox" name="Games/projet_1/assets/'.$entry.'" value=""></label></td>
								          </tr>';
								        }
								    }

								    closedir($handle);
									}
		              ?>
		            </tbody>
						  </table>
		        </div>
		      </div>
		    </div>
		    <div class="panel panel-default">
		      <div class="panel-heading">
		        <h4 class="panel-title">
		            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">img</a>
		        </h4>
		      </div>
		      <div id="collapseThree" class="panel-collapse collapse">
		        <div class="panel-body file-app">

		        	<table class="table">
						    <thead>
						      <tr>
						        <th>Nom du fichier</th>
						        <th>Aperçu du fichier</th>
						        <th>Sélection</th>
						      </tr>
						    </thead>
						    <tbody>
		            	<?php
									if ($handle = opendir('Games/projet_1/img')) {

								    while (false !== ($entry = readdir($handle))) {

								        if ($entry != "." && $entry != "..") {

								          echo '
								          <tr>
								          	<td>'.$entry.'</td>
								          	<td><img data-src="Games/projet_1/img/'.$entry.'" class="lazyload img-responsive"/></td>
								          	<td><label><input type="checkbox" name="Games/projet_1/img/'.$entry.'" value=""></label></td>
								          </tr>';
								        }
								    }
									}
									?>
								</tbody>
						  </table>
		        </div>
		      </div>
		    </div>

		  </div>
		</div>

		<input type="button" id="delete-file-selected" name="" value="supprimer la sélection" class="btn btn-danger">

  </div>
  <div role="tabpanel" class="tab-pane fade" id="add-file">
  	<form id="form_upload-file" action="manage/uploadFile" method="post" enctype="multipart/form-data">
			<legend>Ajouter un fichier</legend>
			<div class="alert alert-warning">
				<span class="glyphicon glyphicon-exclamation-sign"></span>
				Par défaut, le fichier est déposer dans le dossier <b>/transferts</b>
			</div>

			<div class="col-sm-7">
		    <!-- <label class="btn btn-default btn-file"> -->
		        <!-- Choisir un fichier <input type="file" name="file-upload" style="display: none;"> -->
		        <input type="file" class="filestyle" name="file-upload" data-buttonText="Choisir un fichier">
		    <!-- </label> -->
		  </div>
			<input type="submit" name="upload-file" class="btn btn-primary" value="transférer">
		</form>
  </div>
  
</div>