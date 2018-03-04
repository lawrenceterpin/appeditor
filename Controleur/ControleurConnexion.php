<?php

require_once 'Framework/Controleur.php';
require_once 'Modele/Utilisateur.php';

require_once 'Modele/message-alert.php';

/**
 * Contrôleur gérant la connexion au site
 *
 * @author Baptiste Pesquet
 */
class ControleurConnexion extends Controleur
{
    private $utilisateur;

    public function __construct()
    {
        $this->utilisateur = new Utilisateur();
    }

    public function getListtUtilisateursActif() {

        $this->utilisateur->getListtUtilisateursActif();
      }

    public function index()
    {

        if( isset($_COOKIE['login']) ) {
            
            $login_actif = $this->requete->getSession()->getAttribut('login');

            $this->genererVue(
                array(
                    'login_actif' => $login_actif
                )
            );
        }
        else {

            $this->genererVue();
        }
    }

    public function connecter()
    {

        if ($this->requete->existeParametre("login") && $this->requete->existeParametre("mdp")) {
            $login = $this->requete->getParametre("login");
            $mdp = $this->requete->getParametre("mdp");
            if ($this->utilisateur->connecter($login, $mdp)) {
                $utilisateur = $this->utilisateur->getUtilisateur($login, $mdp);
                $this->requete->getSession()->setAttribut("idUtilisateur",
                        $utilisateur['idUtilisateur']);
                $this->requete->getSession()->setAttribut("login",
                        $utilisateur['login']);


                // Création des cookies si tout se passe bien
                setcookie('login', $login, (time() + 3600), '/');
        	    setcookie('mdp', $mdp, (time() + 3600), '/');

                $this->utilisateur->statutUtilisateur($login);

                $this->rediriger("admin");
            }
            else
                // $this->genererVue(array('msgErreur' => 'Login ou mot de passe incorrects'),"index");
                
                $this->genererVue(array('msgErreur' => message_alert("Login ou mot de passe incorrects", 'danger')),"index");
                        
                // message_alert("Login ou mot de passe incorrects", 'danger');
        }
        else
            throw new Exception("Action impossible : login ou mot de passe non défini");
    }

    public function deconnecter()
    {
        $this->requete->getSession()->detruire();
        setCookie('login', '', time() - 3600, '/');
        setCookie('mdp', '', time() - 3600, '/');
        
        $this->rediriger("accueil");
    }

}
