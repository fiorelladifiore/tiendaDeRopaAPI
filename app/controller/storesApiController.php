<?php
require_once 'app/model/storesModel.php';
require_once 'app/controller/controller.php';

class storesApiController extends controller{
    private $model;

    public function __construct() {
        parent::__construct();
        $this->model = new storesModel();
    }

    public function showingStores() {
        try {
            if(!empty($_GET['attribute'])){
                $stores = $this->model->getAll($_GET['attribute'], $_GET['order']);
            }else{
                $stores = $this->model->getAll();
            }
            if($stores){
                $response = [
                "status" => 200,
                "data" => $stores
               ];
                $this->view->response($response, 200);
            }else{
                $this->view->response("No existen tiendas en la base de datos", 404);
            }
        } catch (Exception $e) {
                $this->view->response("Error de servidor", 500);
        }
    }

    public function showingStore($params = null) {
        $id = $params[':ID'];
        try {
            $store = $this->model->getStore($id);
            if($store){
                $response = [
                "status" => 200,
                "message" => $store
               ];
                $this->view->response($response, 200);
            }
            else{
                $response = [
                    "status" => 404,
                    "message" => "No existe la tienda en la base de datos."
                ];
                $this->view->response($response, 404);

            }
        } catch (Exception $e) {
            $this->view->response("Error de servidor", 500);
        }

    }  
    
    public function newStore() {
        try {
            $store = $this->getData();
            if (!isset($store->nombre) || !isset($store->direccion) || !isset($store->telefono) || !isset($store->email)) {
                $this->view->response("Complete los datos", 400);
            }else{
            $nombre=$store->nombre;
            $direccion=$store->direccion;
            $telefono=$store->telefono;
            $email=$store->email;
                $lastId=$this->model->insertStore($nombre, $direccion, $telefono, $email);
                $store=$this->model->getStore($lastId);
                $response = [
                    "status" => 201,
                    "msg" => "Se agrego con éxito la tienda con id $lastId",
                    "tienda" => $store
                    ];
                    $this->view->response($response, 201);  
                }
        }catch(Exception $e) {
            $this->view->response("Error de servidor", 500);
        }
    }

    public function deleteStore($params = null) {
        try{
        $id = $params[':ID'];
        $store = $this->model->getStore($id);
        if($store){
            $this->model->deleteStore($id);

            $this->view->response("Tienda $id, eliminada", 200);
        }else{
            $this->view->response("Tienda $id, no encontrada", 404);
        }
        }catch(Exception $e){
        $this->view->response("Error de servidor", 500);
            }
        }

    public function updateStore($params = null) {
        try{
        $id = $params[':ID'];
        $store = $this->model->getStore($id);
        if ($store) {
            $store = $this->getData();
            $nombre = $store->nombre;
            $direccion = $store->direccion; 
            $telefono = $store->telefono;
            $email = $store->email;
            $this->model->updateStore($nombre, $direccion, $telefono, $email, $id);   
            $this->view->response("Tienda $nombre, modificada", 200);
        } else {
            $this->view->response("Tienda $id, no encontrada", 404);
            }
        }catch(Exception $e) {
        $this->view->response("Error de servidor", 500);
        }
    }    

}
