<?php
require_once 'Framework/Controleur.php';
require_once 'Modele/Utilisateur.php';
/**
 * Contrôleur des actions liées aux billets
 *
 * @author Baptiste Pesquet
 */
class ControleurParametres extends Controleur {

  public function __construct() {
		$this->utilisateur = new Utilisateur();

  }

  // Affiche la liste des pages du book
  public function index() {

    $this->genererVue();
  }

}