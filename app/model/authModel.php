<?php 

require_once "app/model/model.php";

class authModel extends model {

    function getUser($username){
        $db = $this->getConnection();

        
        $sentencia = $db->prepare("SELECT * FROM users WHERE username = ?");
        $sentencia->execute([$username]);
        $user = $sentencia->fetch(PDO::FETCH_OBJ);
        return $user;

    }

}