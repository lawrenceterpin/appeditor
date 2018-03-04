<?php

require_once 'Framework/Controleur.php';
require_once 'Modele/Utilisateur.php';
require_once 'Modele/Billet.php';
require_once 'Modele/Commentaire.php';
/**
 * Contrôleur des actions liées aux billets
 *
 * @author Baptiste Pesquet
 */
class ControleurBillet extends Controleur {

    private $utilisateur;
    private $billet;
    private $commentaire;

    /**
     * Constructeur 
     */
    public function __construct() {

        $this->utilisateur = new Utilisateur();
        $this->billet = new Billet();
        $this->commentaire = new Commentaire();
    }

    // Affiche les détails sur un billet
    public function index() {

        $login_search = 'lawadmin';
        $login_actif = $this->utilisateur->getUtilisateurActif($login_search);

        $login = $this->requete->getSession()->getAttribut("login");

        $idBillet = $this->requete->getParametre("id");
        
        $billet = $this->billet->getBillet($idBillet);
        $commentaires = $this->commentaire->getCommentaires($idBillet);
        
        $this->genererVue(
            array(
                'login_actif' => $login_actif, 
                'login' => $login,
                'billet' => $billet, 
                'commentaires' => $commentaires
        ));
    }

    // Ajoute un commentaire sur un billet
    public function commenter() {
        $idBillet = $this->requete->getParametre("id");
        $auteur = $this->requete->getParametre("auteur");
        $contenu = $this->requete->getParametre("contenu");
        
        $this->commentaire->ajouterCommentaire($auteur, $contenu, $idBillet);
        
        // Exécution de l'action par défaut pour réafficher la liste des billets
        $this->executerAction("index");
    }
}

