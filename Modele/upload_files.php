<?php
function upload_files($field_file) {
	
	
	echo "ok upload file";

	if( !empty($_FILES[$field_file]) ) {
		
		message_alert("champ file rempli, upload possible", 'success');

		$uploadOk = 1;

		$target_dir = $_SERVER["DOCUMENT_ROOT"].'/appeditor/Games/projet_1/img/transferts/';

		$target_file = $target_dir . basename($_FILES[$field_file]["name"]);
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

		if( $imageFileType == "pdf" ) {

			$target_file = $_SERVER["DOCUMENT_ROOT"].'/history-book/Contenu/pdf/' . basename($_FILES[$field_file]["name"]);
		}
		
		
		// echo $_SERVER["DOCUMENT_ROOT"];

		// Check if image file is a actual image or fake image
    /*$check = getimagesize($_FILES[$field_file]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }*/

		// Check if file already exists
		if (file_exists($target_file)) {
		    
		    message_alert("Désolé, le fichier existe déja", 'warning');
		    
		    $uploadOk = 0;
		}
		// Check file size
		/*if ($_FILES["fileToUpload"]["size"] > 500000) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}*/
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "pdf" ) {

		    message_alert("Désolé, seulement les fichiers JPG, JPEG, PNG & GIF sont autorisés", 'danger');
		    
		    $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {

		    message_alert("Désolé, votre fichier n'a pas été téléchargé", 'danger');

		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES[$field_file]["tmp_name"], $target_file)) {
		        
		        message_alert("Le fichier <b>". basename( $_FILES[$field_file]["name"]). "</b> a bien été uploadé", 'success');

		        // echo '<script language="JavaScript" type="text/javascript">document.location="/book"</script>';
		    
		    } else {
		        
		        message_alert('Désolé, il y avait une erreur téléchargeant votre fichier', 'danger');
		    }
		}

	} else {

		message_alert('champ file vide', 'danger');
	}
}