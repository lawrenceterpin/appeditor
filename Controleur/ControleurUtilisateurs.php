<?php
require_once 'Framework/Controleur.php';
require_once 'Modele/Utilisateur.php';

/**
 * Contrôleur des actions liées aux billets
 *
 * @author Baptiste Pesquet
 */
class ControleurUtilisateurs extends Controleur {

  private $utilisateur;

  public function __construct() {
		$this->utilisateur = new Utilisateur();
  }

  public function getListtUtilisateursActif() {

    $this->utilisateur->getListtUtilisateursActif();
  }

  public function sendMessage() {

  	if( isset($_COOKIE['login']) ) {

	  	$login = $this->requete->getSession()->getAttribut("login");
	    // $login_search = 'lawadmin';
	    $login_actif = $this->utilisateur->getUtilisateurActif($login);

	    $this->utilisateur->sendMessage($login_actif['idUtilisateur']);
	  }
  }


  // Affiche les détails sur un billet
  public function index() {

    $utilisateurs = $this->utilisateur->getUtilisateurs();

    $login = $this->requete->getSession()->getAttribut("login");
    // $login_search = 'lawadmin';
    $login_actif = $this->utilisateur->getUtilisateurActif($login);

    $chatrooms = $this->utilisateur->getChatrooms($login_actif['idUtilisateur']);

    if( isset($_COOKIE['login']) ) {

	    $sendMessage = $this->utilisateur->sendMessage($login_actif['idUtilisateur']);
	  }
    
    $this->genererVue(array(
        'utilisateurs' => $utilisateurs,
        'login_actif' => $login_actif,
        'login' => $login,
        'chatrooms' => $chatrooms,
        'sendMessage' => $sendMessage
    ));
  }

}