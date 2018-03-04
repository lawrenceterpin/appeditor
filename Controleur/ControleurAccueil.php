<?php

require_once 'Framework/Controleur.php';
require_once 'Modele/Utilisateur.php';
require_once 'Modele/Billet.php';

require_once 'Modele/message-alert.php';

class ControleurAccueil extends Controleur {

    private $billet;

    public function __construct() {
    	$this->utilisateur = new Utilisateur();
        $this->billet 		 = new Billet();
    }

    // Affiche la liste de tous les billets du blog
    public function index() {
    		// $utilisateur = $this->utilisateur->getUtilisateur();
        $billets = $this->billet->getBillets();
        
        
        if( isset($_COOKIE['login']) ) {
        
        	$this->utilisateur->getUtilisateur($_COOKIE['login'], $_COOKIE['mdp']);
        }
        
    	if( isset($_GET['log_action']) ) {
    		
    		if( $_GET['log_action'] == 'connexion' ) {

    			$login = $_POST['login'];
      	$mdp	 = $_POST['mdp'];
    		
    			$this->utilisateur->connecter($login,$mdp);
    		
    		}
    	}


        $this->genererVue(array(
        	'billets' => $billets
        ));
    }

}