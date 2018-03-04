<?php

require_once 'Framework/Modele.php';

/**
 * Fournit les services d'accès aux genres musicaux 
 * 
 * @author Baptiste Pesquet
 */
class Page extends Modele {

    /** Renvoie la liste des pages du blog
     * 
     * @return PDOStatement La liste des pages
     */
    public function getPages() {
        $sql = 'select PAGE_ID as id_page,'
                . ' PAGE_CONTENU as contenu_page from T_PAGES';
        $pages = $this->executerRequete($sql);
        return $pages;
    }
	
	
	
		/*public function testAction() {
			
			var_dump($_GET);
			
      echo "rendu de la fonction test_action";
    }*/

    /** Renvoie les informations sur un billet
     * 
     * @param int $id L'identifiant du billet
     * @return array Le billet
     * @throws Exception Si l'identifiant du billet est inconnu
     */
    /*public function getPage($idPage) {
        $sql = 'select BIL_ID as id, BIL_DATE as date,'
                . ' BIL_TITRE as titre, BIL_CONTENU as contenu from T_BILLET'
                . ' where BIL_ID=?';
        $billet = $this->executerRequete($sql, array($idBillet));
        if ($billet->rowCount() > 0)
            return $billet->fetch();  // Accès à la première ligne de résultat
        else
            throw new Exception("Aucun billet ne correspond à l'identifiant '$idBillet'");
    }*/

    public function addPage($content) {

        $sql = "insert into T_PAGES (PAGE_CONTENU) values ('".$content."')";
        $pages = $this->executerRequete($sql);

    }


    public function updatePage($id_page, $content) {

      $sql = "update T_PAGES SET PAGE_CONTENU = '.$content.' WHERE PAGE_ID = $id_page";
      $pages = $this->executerRequete($sql);

    }

    public function CallPage() {

      $calls = "variable de test";

      return $calls;
    }

    
    
    /*public function resizeImage($x, $y, $file_img, $style, $file_img)
	  {
	  	
	  	
			resize_crop_image($x, $y, 'Contenu/img/'.$file_img, 'Contenu/img/styles/style_'.$style.'/'.$file_img);
	    	
			// $this->rediriger("book");
	  }*/
}