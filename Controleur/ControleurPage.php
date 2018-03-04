<?php

require_once 'Framework/Controleur.php';
require_once 'Modele/Page.php';

/**
 * Contrôleur des actions liées aux pages
 *
 * @author Baptiste Pesquet
 */
class ControleurPage extends Controleur {

    private $page;
    
    /**
     * Constructeur 
     */
    public function __construct() {
        $this->page = new Page();
    }

    // Affiche les détails sur une page
    public function index() {

        $idPage = $this->requete->getParametre("id");
        
        $page = $this->page->getPage($idPage);
        
        $this->genererVue(array('page' => $page));
    }
}

