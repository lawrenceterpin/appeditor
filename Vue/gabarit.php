<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <base href="<?= $racineWeb ?>">
    <title><?= $titre ?> - AppEditor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <?php
    $dependances_json[] = file_get_contents("Contenu/dependances/dependances.json");

    foreach ($dependances_json as $string) {

        $array_dependances = $string;

        $array_files_css = json_decode($string, true)["files_css"];

        foreach($array_files_css as $dependance => $value) {

            echo '<link rel="stylesheet" type="text/css" href="'.$value.'">';
        }
    }
    ?>

    <!-- Appels CSS spécifiques à la page -->
    <?php
    if( isset($css) ) {
        foreach ($css as $link_css) {
            echo '<link rel="stylesheet" type="text/css" href="'.$link_css.'">';
        };
    }
  	?>

    <link rel="stylesheet" type="text/css" href="/appeditor/Contenu/css/styles.css">
    
  </head>
  
  <body class="<?php echo $classBody;?>">

  	<div id="loading">
			<div></div>
		</div>

    <section id="wrapper-content">

      <div class="overlay"></div>

      <!-- Navigation -->
      <?php
      include_once('header.php');
      ?>
  
      <!-- Sidebar -->
      <nav class="navbar navbar-inverse" id="sidebar-wrapper">
          <ul class="nav sidebar-nav">
              <li class="sidebar-brand">
                  <a href="#">
                     App Editor
                  </a>
              </li>
              <!-- <li>
                  <a href="#">Home</a>
              </li>
              <li>
                  <a href="#">About</a>
              </li>
              <li>
                  <a href="#">Events</a>
              </li>
              <li>
                  <a href="#">Team</a>
              </li> -->
              <li class="dropdown open liste-utilisateurs">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"  aria-expanded="true">Utilisateurs en ligne <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <!-- <li class="dropdown-header">Dropdown heading</li>
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li> -->
                  <li>
                  	<div id="liste-utilisateurs"></div>
                  </li>
                </ul>
              </li>
              <!-- <li>
                  <a href="#">Services</a>
              </li>
              <li>
                  <a href="#">Contact</a>
              </li>
              <li>
                  <a href="https://twitter.com/maridlcrmn">Follow me</a>
              </li> -->
          </ul>
      </nav>
      <!-- /#sidebar-wrapper -->

      <!-- Page Content -->
      <div id="page-content-wrapper">
          <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
              <span class="hamb-top"></span>
  						<span class="hamb-middle"></span>
							<span class="hamb-bottom"></span>
          </button>
      </div>
      <!-- /#page-content-wrapper -->

			<?= $contenu ?>

    </section> <!-- #contenu -->

    <!-- Footer -->
    <?php
		include_once('footer.php');
		?>

    <?php
		foreach ($dependances_json as $string) {

			$array_dependances = $string;

			$array_files_js = json_decode($string, true)["files_js"];

			foreach($array_files_js as $dependance => $value) {

				echo '<script type="text/javascript" src="'.$value.'"></script>';
			}
		}
		?>

		<!-- Appels JS spécifiques à la page -->
		<?php
		if( isset($scripts) ) {
	  	foreach ($scripts as $link_script) {
	  		echo '<script type="text/javascript" src="'.$link_script.'"></script>';
	  	};
	  }
  	?>

  	<script type="text/javascript" src="Contenu/js/functions.js"></script>
    
  </body>
</html>