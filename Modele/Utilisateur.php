<?php

require_once 'Framework/Modele.php';

/**
 * Modélise un utilisateur du blog
 *
 * @author Baptiste Pesquet
 */
class Utilisateur extends Modele {

    /**
     * Vérifie qu'un utilisateur existe dans la BD
     * 
     * @param string $login Le login
     * @param string $mdp Le mot de passe
     * @return boolean Vrai si l'utilisateur existe, faux sinon
     */
    public function connecter($login, $mdp)
    {
        $sql = "select UTIL_ID from T_UTILISATEUR where UTIL_LOGIN=? and UTIL_MDP=?";
        $utilisateur = $this->executerRequete($sql, array($login, $mdp));
        return ($utilisateur->rowCount() == 1);
    }

    public function statutUtilisateur($login) {

      $sql = "update T_UTILISATEUR SET UTIL_STAT = '1' WHERE UTIL_LOGIN = ?";
      $utilisateur = $this->executerRequete($sql, array($login));

    }

    /**
     * Renvoie un utilisateur existant dans la BD
     * 
     * @param string $login Le login
     * @param string $mdp Le mot de passe
     * @return mixed L'utilisateur
     * @throws Exception Si aucun utilisateur ne correspond aux paramètres
     */
    public function getUtilisateur($login, $mdp)
    {
        $sql = "select UTIL_ID as idUtilisateur, UTIL_LOGIN as login, UTIL_MDP as mdp 
            from T_UTILISATEUR where UTIL_LOGIN=? and UTIL_MDP=?";
        $utilisateur = $this->executerRequete($sql, array($login, $mdp));
        if ($utilisateur->rowCount() == 1)
            return $utilisateur->fetch();  // Accès à la première ligne de résultat
        else
            throw new Exception("Aucun utilisateur ne correspond aux identifiants fournis");
    }


    public function getUtilisateurs()
    {
        $sql = "select UTIL_ID as idUtilisateur, UTIL_LOGIN as login, UTIL_MDP as mdp 
            from T_UTILISATEUR";
        $utilisateurs = $this->executerRequete($sql);
        return $utilisateurs;
    }


    public function getListtUtilisateursActif()
    {
        $sql = "select UTIL_ID as idUtilisateur, UTIL_LOGIN as login, UTIL_MDP as mdp, UTIL_STAT as statut 
        from T_UTILISATEUR where UTIL_STAT=1";
        $utilisateurs = $this->executerRequete($sql);

        // echo '<span id="nb-user-actif">'.$utilisateurs->rowCount().'</span>';

        echo "<ul>";

        foreach ($utilisateurs as $utilisateur) {
            echo '<li><span>'.$utilisateur['login'].'</span></li>';
        }

        echo "</ul>";
    }



    public function getUtilisateurActif($login_search)
    {

        $sql = "select UTIL_ID as idUtilisateur, UTIL_LOGIN as login, UTIL_MDP as mdp 
            from T_UTILISATEUR where UTIL_LOGIN=?";
        $utilisateur = $this->executerRequete($sql, array($login_search));
        if ($utilisateur->rowCount() == 1)
            return $utilisateur->fetch();  // Accès à la première ligne de résultat
        else
            throw new Exception("Aucun utilisateur ne correspond aux identifiants fournis");
    }


    public function getChatrooms($idUtilisateur)
    {

        // echo $idUtilisateur;

        $sql = "select * from chat_room left join chat on chat.chat_room_id=chat_room.chat_room_id where userid='".$idUtilisateur."' GROUP BY chat.chat_room_id";
        /*$sql = "select chat_room_id as chat_room_id, chat_room_name as chat_room_name
            from chat_room";*/
        $chatrooms = $this->executerRequete($sql);
        return $chatrooms;
    }

    public function sendMessage($idUtilisateur)
    {

        if(isset($_POST['res']) && $_POST['res'] == 1 ){

            $id = $_POST['id'];

            $sql = "select * from chat left join T_UTILISATEUR on T_UTILISATEUR.UTIL_ID=chat.userid where chat_room_id='".$id."' order by chat_date asc";
            // $sql = "select * from chat where chat_room_id='".$id."' order by chat_date asc";
            $chatroom = $this->executerRequete($sql);

            if ($chatroom->rowCount() > 0) {
                // echo $chatroom->fetch();  // Accès à la première ligne de résultat

                // var_dump($chatroom->fetch());

                foreach ($chatroom as $chatroom_message) {

                    if( $chatroom_message["UTIL_ID"] == $idUtilisateur ) {

                        $type_message = 'send';
                        $text_message = '<b>Vous</b>';
                    }
                    else {
                        $type_message = 'received';
                        $text_message = '<b>'.$chatroom_message["UTIL_LOGIN"].'</b>';
                    }

                    echo "<li class='".$type_message."'>";

                        echo $text_message.'<br>';

                        echo '<div class="message">'.$chatroom_message['chat_msg'].'</div>';

                    echo "</li>";
                }

            } else {

                echo 'aucun message';
                // throw new Exception("Aucun message");
            }
        }
        else {

            $msg    = addslashes($_POST['msg']);
            $id     = $_POST['id'];
            $userid = $_POST['userid'];

            $sql = "insert into chat (chat_room_id, chat_msg, userid, chat_date) values ('$id', '$msg' , '".$userid."', NOW())";
            $chatrooms = $this->executerRequete($sql);
            return $chatrooms;
        }
    }
}