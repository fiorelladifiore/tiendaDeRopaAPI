<?php
require_once 'app/model/storesModel.php';
require_once 'app/view/JSONView.php';

class storesApiController {

    private $model;
    private $view;
    private $data;

    public function __construct() {
        $this->model = new storesModel();
        $this->view = new JSONView();
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function showingStores() {
        try {
            $stores = $this->model->getAll();
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
        $store = $newStore = $this->getData();
        if($store){
        $lastId = $this->model->insertStore(
                $store->nombre, 
                $store->direccion,
                $store->telefono,
                $store->email);
        $this->view->response("agregado exitoso con id: $lastId", 200);  
        }else{
         $this->view->response("No existen tiendas en la base de datos", 404);
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
            $this->view->response("Tienda $nombre, finalizada", 200);
        } else {
            $this->view->response("Tienda $id, no encontrada", 404);
            }
        }catch(Exception $e) {
        $this->view->response("Error de servidor", 500);
        }
    }    

}

