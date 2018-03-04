<?php

require_once 'Configuration.php';

/**
 * Classe modélisant une vue.
 *
 * @author Baptiste Pesquet
 */
class Vue
{
    /** Nom du fichier associé à la vue */
    private $fichier;

    private $login_actif;

    /** Titre de la vue (défini dans le fichier vue) */
    private $titre;

    private $css;

    private $scripts; 

    /**
     * Constructeur
     * 
     * @param string $action Action à laquelle la vue est associée
     * @param string $controleur Nom du contrôleur auquel la vue est associée
     */
    public function __construct($action, $controleur = "")
    {
        // Détermination du nom du fichier vue à partir de l'action et du constructeur
        // La convention de nommage des fichiers vues est : Vue/<$controleur>/<$action>.php
        $fichier = "Vue/";
        if ($controleur != "") {
            $fichier = $fichier . $controleur . "/";
        }
        $this->fichier = $fichier . $action . ".php";
    }

    /**
     * Génère et affiche la vue
     * 
     * @param array $donnees Données nécessaires à la génération de la vue
     */
    public function generer($donnees)
    {
        // Génération de la partie spécifique de la vue
        $contenu = $this->genererFichier($this->fichier, $donnees);
        // On définit une variable locale accessible par la vue pour la racine Web
        // Il s'agit du chemin vers le site sur le serveur Web
        // Nécessaire pour les URI de type controleur/action/id
        $racineWeb = Configuration::get("racineWeb", "/");
        // Génération du gabarit commun utilisant la partie spécifique

        $login_actif = $_COOKIE["login"];

        function classBody_titre($titre_page) {

            $lowercase_titre = strtolower($titre_page);

            $unwanted_array = array(
                'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E','Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U','Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c','è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o','ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

            $no_accent_titre = strtr( $lowercase_titre, $unwanted_array );

            $no_space_titre = str_replace(' ', '-', $no_accent_titre);

            $no_quotes_titre = str_replace('\'', '-', $no_space_titre);

            $classBody       = $no_quotes_titre;

            return $classBody;
        }


        $vue = $this->genererFichier('Vue/gabarit.php',
                array(
                    'login_actif' => $login_actif,
                    'titre' => $this->titre,
                    'classBody' => classBody_titre($this->titre), 
                    'css' => $this->css, 
                    'scripts' => $this->scripts, 
                    'contenu' => $contenu, 
                    'racineWeb' => $racineWeb
                ));
        // Renvoi de la vue générée au navigateur
        echo $vue;
    }

    /**
     * Génère un fichier vue et renvoie le résultat produit
     * 
     * @param string $fichier Chemin du fichier vue à générer
     * @param array $donnees Données nécessaires à la génération de la vue
     * @return string Résultat de la génération de la vue
     * @throws Exception Si le fichier vue est introuvable
     */
    private function genererFichier($fichier, $donnees)
    {
        if (file_exists($fichier)) {
            // Rend les éléments du tableau $donnees accessibles dans la vue
            extract($donnees);
            // Démarrage de la temporisation de sortie
            ob_start();
            // Inclut le fichier vue
            // Son résultat est placé dans le tampon de sortie
            require $fichier;
            // Arrêt de la temporisation et renvoi du tampon de sortie
            return ob_get_clean();
        }
        else {
            throw new Exception("Fichier '$fichier' introuvable");
        }
    }

    /**
     * Nettoie une valeur insérée dans une page HTML
     * Doit être utilisée à chaque insertion de données dynamique dans une vue
     * Permet d'éviter les problèmes d'exécution de code indésirable (XSS) dans les vues générées
     * 
     * @param string $valeur Valeur à nettoyer
     * @return string Valeur nettoyée
     */
    private function nettoyer($valeur)
    {
        // Convertit les caractères spéciaux en entités HTML
        return htmlspecialchars($valeur, ENT_QUOTES, 'UTF-8', false);
    }

}
