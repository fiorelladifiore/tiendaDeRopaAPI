<?php

require_once "app/model/model.php";

class productsModel extends model{

    function getAll(){
        $db = $this->getConnection();

        $sentencia = $db->prepare("SELECT * FROM ropa");
        $sentencia->execute();
        $products= $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    function getProdStore($id){
        $db = $this->getConnection();

        $sentencia = $db->prepare("SELECT * FROM ropa r WHERE r.id_tienda = ?");
        $sentencia->execute([$id]);
        $prod = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $prod;
    }

    function getProduct($id){
        $db = $this->getConnection();

        $sentencia = $db->prepare("SELECT r.*, t.id_tienda FROM ropa r JOIN tienda t ON r.id_tienda = t.id_tienda WHERE r.id_ropa = ?");
        $sentencia->execute([$id]);
        $product= $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $product;
    }

    function getProductEdit($id){
        $db = $this->getConnection();

        $sentencia = $db->prepare("SELECT *, t.id_tienda, t.nombre FROM ropa r JOIN tienda t ON r.id_tienda = t.id_tienda WHERE r.id_ropa = ?");
        $sentencia->execute([$id]);
        $product= $sentencia->fetch(PDO::FETCH_OBJ);
        return $product;
    }

    function deleteProduct($id){
        $db = $this->getConnection();
        $resultado=$db->prepare("DELETE FROM ropa WHERE id_ropa=?");
        $resultado->execute([$id]);
    }

    function addProduct($tipo, $descripcion, $talle, $precio, $id_tienda, $imagen = null){ 
        $db = $this->getConnection();

        $resultado= $db->prepare("INSERT INTO ropa (tipo, descripcion, talle, precio, imagen, id_tienda) VALUES (?,?,?,?,?,?)");
        $resultado->execute([$tipo, $descripcion, $talle, $precio, $imagen, $id_tienda]);
        return $db->lastInsertId();
    }   

    function getStoAndProd(){
        $db = $this->getConnection();
           
        $sentencia = $db->prepare("SELECT * FROM ropa r, tienda t WHERE r.id_tienda = t.id_tienda");
        $sentencia->execute();
        $stores = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $stores;
    }

    function updateProduct($tipo, $descripcion, $precio, $talle, $id_tienda, $id){
        $db = $this->getConnection();
    
        $resultado= $db->prepare("UPDATE ropa SET tipo=?, descripcion=?, precio=?, talle=?, id_tienda=? WHERE id_ropa = ?");
        $resultado->execute([$tipo, $descripcion, $precio, $talle, $id_tienda, $id]);
     }



    }