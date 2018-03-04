<?php
$name_fonction 	  	  = $_POST['name-fonction'];
$list_dependances_js  = $_POST['list-dependances-js'];
$list_dependances_css = $_POST['list-dependances-css'];
$copy_file						= $_POST['copy-file'];
$path_file_copy				= $_POST['path-file-copy'];

// $new_content          = $_POST['new-content'];
// $path_file_editeur	  = $_POST['path-file-editeur'];


if( !empty($name_fonction) ) {

	$fileName = "Contenu/js/functions.js";
	$lineNumber = 1;

	$changeTo = "function ".$name_fonction."() { \n
		alert('fonction automatisée --> ".$name_fonction."');\n
	}\n
	".$name_fonction."();\n\n";

	$contents = file($fileName);

	foreach ($contents as $key => $value) {
	  $new_contents[] = $value;
	  if ($key == $lineNumber) {
	    $new_contents[] = $changeTo;
	  }
	}

	file_put_contents($fileName, implode('',$new_contents));

	echo "<pre><code>".file_get_contents($fileName)."</code></pre>";
}


if( !empty($list_dependances_js) || !empty($list_dependances_css) ) {

	// header('Content-Type: text/plain; charset=utf-8'); 

	// echo '--> value dépendance : '.$list_dependances_js;

	$dependances_json[] = file_get_contents("Contenu/dependances/dependances.json");

	// var_dump($dependances_json);

	foreach ($dependances_json as $string) {

		// var_dump(json_decode($string, true)["files"]);

		$new_array_files_js = array();

		$array_files_js = json_decode($string, true)["files_js"];

		foreach ($array_files_js as $key => $file) {

			array_push($new_array_files_js, nl2br($file));
		}

		if( $list_dependances_js != "0" ) {

			// add value JS in array JSon
			array_push($new_array_files_js, $list_dependances_js);
		}


		$new_array_files_css = array();

		$array_files_css = json_decode($string, true)["files_css"];

		foreach ($array_files_css as $key => $file) {

			array_push($new_array_files_css, nl2br($file));
		}

		if( $list_dependances_css != "0" ) {

			// add value CSS in array JSon
			array_push($new_array_files_css, $list_dependances_css);
		}


		// var_dump($new_array_files_css);

		// var_dump(json_encode($array_files_js, JSON_FORCE_OBJECT));

		$new_json = [
			"files_js" => $new_array_files_js,
			"files_css" => $new_array_files_css
		];

		$new_json_dependances = json_encode($new_json, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);

		// var_dump($new_json);

		file_put_contents("Contenu/dependances/dependances.json",$new_json_dependances);
	}
}


/*if( !empty($new_content) ) {

	// echo 'ok New content -> '.$new_content;

	file_put_contents($path_file_editeur,$new_content);
}


// Si on poste une édition ou publication de fichiers
if( isset($_POST['path-file-pub']) || isset($_POST['path-file-edit']) ) {

  // echo 'file-edit/file-pub ok';

	// Si l'évènement de soumission existe bien ( 'pub' ou 'edit' )
	if( isset($_POST['submit-event']) ) {

		// On récupère le nom du fichier en édition
		$filename = $_POST['path-file-edit'];

		// Si le fichier en édition existe
		if (file_exists($filename)) {

			// On récupère le contenu du fichier en édition
			$content_file         = file_get_contents($_POST['path-file-edit']);

			// Si on veut publier le fichier en édition
			if( $_POST['submit-event'] == 'pub' ) {

				// On insère le contenu du fichier en édtion dans celui déja publié
	    	file_put_contents($_POST['path-file-pub'],$content_file);

				echo file_get_contents($_POST['path-file-pub']);

				// echo "PUB ( on insère le contenu du fichier édité dans celui publié )";
			}
			else if( $_POST['submit-event'] == 'edit' ) {

				echo file_get_contents($_POST['path-file-edit']);

				// echo "EDIT ( on récupère le contenu du fichier edité )";
			}
		}
		else {

			// On créé le nouveau fichier à éditer
	    $myfile = fopen($_POST['path-file-edit'], "w") or die("Unable to open file!");

	    // On récupère le contenu du fichier publié
	    $content_file         = file_get_contents($_POST['path-file-pub']);

	    // On insère le contenu du fichier publié dans celui à éditer
	    file_put_contents($_POST['path-file-edit'],$content_file);

	    echo file_get_contents($_POST['path-file-edit']);
		}
	}
}*/



if( isset($_GET['file-selected']) ) {

	echo 'ok get selected file';

	echo $_GET['file-selected'];

	$array_files_selected = explode(',', $_GET['file-selected']);

	foreach ($array_files_selected as $file_selected) {

		unlink('../'.$file_selected);
	}

	// unlink('../Games/projet_1/test/test.txt');
}

/*if( isset($copy_file) ) {

	copy($path_file_editeur,$path_file_copy);
}*/