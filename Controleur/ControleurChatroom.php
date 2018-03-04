<?php
require_once 'Framework/Controleur.php';
require_once 'Modele/Utilisateur.php';
require_once 'Modele/Chatroom.php';

/**
 * Contrôleur des actions liées aux billets
 *
 * @author Baptiste Pesquet
 */
class ControleurChatroom extends Controleur {

  private $chatroom;
  private $utilisateur;

  public function __construct() {

		$this->chatroom    = new Chatroom();
    $this->utilisateur = new Utilisateur();
  }


  /*public function getChatroom() {

  	if( isset($_COOKIE['login']) ) {

	  	$login = $this->requete->getSession()->getAttribut("login");
	    // $login_search = 'lawadmin';
	    $login_actif = $this->utilisateur->getUtilisateurActif($login);

	    $this->chatroom->getChatroom();

	  }
  }*/


  // Affiche les détails sur un billet
  public function index() {

    $utilisateurs = $this->utilisateur->getUtilisateurs();

    $login = $this->requete->getSession()->getAttribut("login");

    $login_actif = $this->utilisateur->getUtilisateurActif($login);

    $chatroom = $this->chatroom->getChatroom();
    
    $this->genererVue(array(
        'utilisateurs' => $utilisateurs,
        'login_actif' => $login_actif,
        'login' => $login,
        'chatroom' => $chatroom,
    ));
  }

}