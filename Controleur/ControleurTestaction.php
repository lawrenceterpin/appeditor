<?php

require_once 'Framework/Controleur.php';
require_once 'Modele/Page.php';

require_once 'Modele/message-alert.php';

/**
 * Contrôleur gérant la connexion au site
 *
 * @author Baptiste Pesquet
 */
class ControleurTestaction extends Controleur
{
    private $page;

    public function __construct()
    {
        $this->utilisateur = new Utilisateur();
    }

    public function index()
    {
        $this->genererVue();
    }

    public function testAction()
    {
    	
    	echo "rendu de la fonction test action";
    }

}
