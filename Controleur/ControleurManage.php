<?php
require_once 'Framework/Controleur.php';
require_once 'Modele/Manage.php';
require_once 'Modele/Utilisateur.php';

require_once 'Modele/upload_files.php';
require_once 'Modele/resize-images.php';
require_once 'Modele/message-alert.php';
/**
 * Contrôleur des actions liées aux billets
 *
 * @author Baptiste Pesquet
 */
class ControleurManage extends Controleur {

  public function __construct() {

    $this->manage      = new Manage();
    $this->utilisateur = new Utilisateur();
  }


  public function index() {

    $files = $this->manage->getFiles();
    $formatSizeUnits = $this->manage->formatSizeUnits(0);

    
    $this->genererVue(array(
      'files' => $files,
        'formatSizeUnits' => $formatSizeUnits
    ));
  }

  public function editFiles()
  {

    $this->manage->editFiles();
  }

  public function uploadFile()
  {
    upload_files('file-upload');
      
    $this->rediriger("manage");
  }
  
  
  public function resizeImage()
  {
    
    $x        = $_POST['largeur-image'];
    $y        = $_POST['hauteur-image'];
    $style    = $x.'x'.$y;
    $file_img = $_POST['image'];
    
    // echo 'largeur : '.$x.' -- hauteur : '.$y.' -- style : '.$style.' -- fichier : '.$file_img;
    
    resize_crop_image($x, $y, 'Contenu/img/'.$file_img, 'Contenu/img/styles/style_'.$style.'/'.$file_img);
    
    
    echo '<img src="Contenu/img/styles/style_'.$style.'/'.$file_img.'"/>';
      
    // $this->rediriger("book");
  }

}