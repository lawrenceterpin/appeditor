<?php

require_once 'Framework/Modele.php';

/**
 * Fournit les services d'accès aux genres musicaux 
 * 
 * @author Baptiste Pesquet
 */
class Game extends Modele {

    /** Renvoie la liste des billets du blog
     * 
     * @return PDOStatement La liste des billets
     */
    public function getGames() {
        $sql = 'select GAME_ID as id, GAME_DATE as date,'
                . ' GAME_TITRE as titre, GAME_CONTENU as contenu from T_GAME'
                . ' order by GAME_ID desc';
        $games = $this->executerRequete($sql);
        return $games;
    }

    /** Renvoie les informations sur un billet
     * 
     * @param int $id L'identifiant du billet
     * @return array Le billet
     * @throws Exception Si l'identifiant du billet est inconnu
     */
    public function getGame($idGame) {
        $sql = 'select GAME_ID as id, GAME_DATE as date,'
                . ' GAME_TITRE as titre, GAME_CONTENU as contenu from T_GAME'
                . ' where GAME_ID=?';
        $game = $this->executerRequete($sql, array($idGame));
        if ($game->rowCount() > 0)
            return $game->fetch();  // Accès à la première ligne de résultat
        else
            throw new Exception("Aucun jeu ne correspond à l'identifiant '$idGame'");
    }

    /**
     * Renvoie le nombre total de billets
     * 
     * @return int Le nombre de billets
     */
    public function getNombreGames()
    {
        $sql = 'select count(*) as nbGames from T_GAME';
        $resultat = $this->executerRequete($sql);
        $ligne = $resultat->fetch();  // Le résultat comporte toujours 1 ligne
        return $ligne['nbGames'];
    }
}