<?php

require_once 'ControleurSecurise.php';
require_once 'Modele/Utilisateur.php';
require_once 'Modele/Billet.php';
require_once 'Modele/Commentaire.php';

/**
 * Contrôleur des actions d'administration
 *
 * @author Baptiste Pesquet
 */
class ControleurAdmin extends ControleurSecurise
{

    private $utilisateur;
    private $billet;
    private $commentaire;

    /**
     * Constructeur 
     */
    public function __construct()
    {
        $this->utilisateur = new Utilisateur();
        $this->billet      = new Billet();
        $this->commentaire = new Commentaire();
    }

    public function addBillet()
    {
        // $content = mysql_real_escape_string($_POST['content-page']);

        $titre = mysql_real_escape_string($_POST['titre']);

        $contenu = mysql_real_escape_string($_POST['contenu']);

        $this->billet->addBillet($titre,$contenu);
        
        $this->rediriger("billets");
    }

    public function index()
    {
        $login_search = 'lawadmin';
        $login_actif = $this->utilisateur->getUtilisateurActif($login_search);

        $utilisateurs = $this->utilisateur->getUtilisateurs();

        $nbBillets = $this->billet->getNombreBillets();
        $nbCommentaires = $this->commentaire->getNombreCommentaires();

        $login = $this->requete->getSession()->getAttribut("login");
        $this->genererVue(
            array(
                'login_actif' => $login_actif, 
                'utilisateurs' => $utilisateurs,
                'nbBillets' => $nbBillets, 
                'nbCommentaires' => $nbCommentaires, 
                'login' => $login
            ));
    }

}

