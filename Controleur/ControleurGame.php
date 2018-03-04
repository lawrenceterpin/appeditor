<?php

require_once 'Framework/Controleur.php';
require_once 'Modele/Game.php';
/**
 * Contrôleur des actions liées aux billets
 *
 * @author Baptiste Pesquet
 */
class ControleurGame extends Controleur {

    private $game;

    /**
     * Constructeur 
     */
    public function __construct() {
        $this->game = new Game();
    }

    // Affiche les détails sur un billet
    public function index() {
        $idGame = $this->requete->getParametre("id");
        
        $game = $this->game->getGame($idGame);
        
        $this->genererVue(array('game' => $game));
    }

}

