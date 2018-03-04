<?php 
$this->titre = "Editeur d'applications"; 

$this->css = array(
	"Contenu/codemirror/lib/codemirror.css",
);

$this->scripts = array(
  "Contenu/codemirror/lib/codemirror.js",
  // "Contenu/codemirror/mode/xml/xml.js",
  "Contenu/codemirror/mode/javascript/javascript.js",
  "Contenu/codemirror/mode/css/css.js",
  "Contenu/codemirror/mode/htmlmixed/htmlmixed.js",
  "Contenu/codemirror/addon/selection/active-line.js",
  "Contenu/codemirror/addon/edit/matchbrackets.js",
	);
?>

<?php
// $dependances_json[] = file_get_contents("Contenu/dependances/dependances.json");

include_once('get_file.php');
?>


<div class="container-fluid">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo $this->titre; ?></h1>
		
  	<div class="col-lg-6">
  		<div class="row">
	  		<div id="actions">
		  		<ul class="nav nav-tabs" role="tablist">
						<li class="active nav-item">
					    <a class="nav-link" href="#app-apercu" role="tab" data-toggle="tab">Aperçu de l'application (projet_1)</a>
					  </li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active" id="app-apercu">
							<span id="reload-iframe" class="glyphicon glyphicon-refresh"></span>
							<div class="loading-preview">
								<img src="Contenu/img/Ripple.gif" class="loading">
							</div>
							<div id="iframe-preview"></div>
		  				<!-- <iframe id="view_edit" width="100%" height="605" data-src="/appeditor/Games/projet_1/index.php"></iframe> -->
		  			</div>
		  		</div>
		  	</div>
		  </div>
  	</div>

  	<div class="col-lg-6">
  		<div id="actions-app-edit">
	  		<?php include_once('block-edit-app.php'); ?>
	  	</div>
  	</div>

	</div>
</div>