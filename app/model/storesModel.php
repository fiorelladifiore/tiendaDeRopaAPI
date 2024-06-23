<?php

require_once "app/model/model.php";

class storesModel extends model{

    function getAll($orderBy, $orderDir){
        $db = $this->getConnection();

        $sentence = $db->prepare("SELECT * FROM tienda ORDER BY $orderBy $orderDir");
        $sentence->execute();
        $stores = $sentence->fetchAll(PDO::FETCH_OBJ);
        return $stores;
    }

    function insertStore($nombre, $direccion, $telefono, $email){
            $db = $this->getConnection();
    
            $sentence= $db->prepare("INSERT INTO tienda (nombre, direccion, telefono, email) VALUES (?,?,?,?)");
            $store = $sentence->execute([$nombre, $direccion, $telefono, $email]);
            return $store;
    }

    function deleteStore($id){
            $db = $this->getConnection();

            $sentence = $db->prepare("DELETE FROM tienda WHERE id_tienda = ?");
            $sentence->execute([$id]);
    }

    function getStore($id){
            $db = $this->getConnection();

            $sentence = $db->prepare("SELECT * FROM tienda WHERE id_tienda = ?");
            $sentence->execute([$id]);
            $store = $sentence->fetch(PDO::FETCH_OBJ);
            return $store;
    }

    function updateStore($nombre, $direccion, $telefono, $email, $id_tienda){
        $db = $this->getConnection();

        $resultado= $db->prepare("UPDATE tienda SET nombre=?, direccion=?, telefono=?, email=? WHERE id_tienda = ?");
        $resultado->execute([$nombre, $direccion, $telefono, $email, $id_tienda]);
    }





}