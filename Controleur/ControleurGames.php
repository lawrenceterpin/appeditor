<?php

require_once 'Framework/Controleur.php';
require_once 'Modele/Utilisateur.php';
require_once 'Modele/Game.php';

require_once 'Modele/message-alert.php';

class ControleurGames extends Controleur {

    private $game;

    public function __construct() {
        $this->utilisateur = new Utilisateur();
        $this->game      = new Game();
    }

    // Affiche la liste de tous les billets du blog
    public function index() {
        // $utilisateur = $this->utilisateur->getUtilisateur();
        $games = $this->game->getGames();
        
        
        if( isset($_COOKIE['login']) ) {
        
          $this->utilisateur->getUtilisateur($_COOKIE['login'], $_COOKIE['mdp']);
        }


        if( isset($_GET['log_action']) ) {
          
          if( $_GET['log_action'] == 'connexion' ) {
  
            $login = $_POST['login'];
            $mdp   = $_POST['mdp'];
          
            $this->utilisateur->connecter($login,$mdp);
          
          }
        }


        $this->genererVue(array(
          'games' => $games
        ));
    }

}
