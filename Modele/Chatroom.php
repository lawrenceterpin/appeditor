<?php

require_once 'Framework/Modele.php';

/**
 * Modélise un utilisateur du blog
 *
 * @author Baptiste Pesquet
 */
class Chatroom extends Modele {


    public function getChatrooms($idUtilisateur)
    {

        // echo $idUtilisateur;

        $sql = "select * from chat_room left join chat on chat.chat_room_id=chat_room.chat_room_id where userid='".$idUtilisateur."' GROUP BY chat.chat_room_id";
        /*$sql = "select chat_room_id as chat_room_id, chat_room_name as chat_room_name
            from chat_room";*/
        $chatrooms = $this->executerRequete($sql);
        return $chatrooms;
    }
    


    public function getChatroom()
    {

        // if(isset($_POST['res']) && $_POST['res'] == 1 ){

            $id = $_POST['res'];

            $sql = "select * from chat left join T_UTILISATEUR on T_UTILISATEUR.UTIL_ID=chat.userid where chat_room_id='".$id."' order by chat_date asc";
            // $sql = "select * from chat where chat_room_id='".$id."' order by chat_date asc";
            $chatroom = $this->executerRequete($sql);

            // var_dump($chatroom);

            return $chatroom;

            /*if ($chatroom->rowCount() > 0) {
                // echo $chatroom->fetch();  // Accès à la première ligne de résultat

                // var_dump($chatroom->fetch());

                return $chatroom;

            } else {

                echo 'aucun message';
                // throw new Exception("Aucun message");
            }*/
        // }
    }
}