<?php

require_once 'Framework/Modele.php';

/**
 * Fournit les services d'accès aux genres musicaux 
 * 
 * @author Baptiste Pesquet
 */
class Manage extends Modele {

    public function editFiles() {


        $new_content          = $_POST['new-content'];
        $path_file_editeur    = $_POST['path-file-editeur'];


        if( !empty($new_content) ) {

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

                        $sql = "update T_FILES SET FILE_AUTEUR = 'lawadmin' WHERE FILE_NAME = ?";
                        $file = $this->executerRequete($sql, array($_POST['path-file-pub']));

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

                    $auteur = 'lawadmin';

                    $sql = "insert into T_FILES (FILE_DATE,FILE_NAME,FILE_AUTEUR) values (NOW(),'".$_POST['path-file-edit']."','".$auteur."')";
                    $file = $this->executerRequete($sql);

                    // On créé le nouveau fichier à éditer
                    $myfile = fopen($_POST['path-file-edit'], "w") or die("Unable to open file!");

                    // On récupère le contenu du fichier publié
                    $content_file         = file_get_contents($_POST['path-file-pub']);

                    // On insère le contenu du fichier publié dans celui à éditer
                    file_put_contents($_POST['path-file-edit'],$content_file);

                    echo file_get_contents($_POST['path-file-edit']);
                }
            }
        }



        if( isset($_GET['file-selected']) ) {

            // echo 'ok get selected file';

            echo $_GET['file-selected'];

            /*$array_files_selected = explode(',', $_GET['file-selected']);

            foreach ($array_files_selected as $file_selected) {

                unlink('../'.$file_selected);
            }*/

        }
    }


    public function getFiles() {

        $sql = 'select FILE_ID as fileid, FILE_DATE as filedate,'
                . ' FILE_NAME as filename, FILE_AUTEUR as fileauteur from T_FILES'
                . ' order by FILE_DATE desc';
        $files = $this->executerRequete($sql);

        return $files;
    }


    public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}