<?php
require_once 'app/model/productsModel.php';
require_once 'app/controller/controller.php';

class productsApiController extends controller{
    private $model;

    public function __construct() {
        parent::__construct();
        $this->model = new productsModel();
    }

    public function getProducts() {
        try {
            $products = $this->model->getAll();
            if($products){
                $response = [
                "status" => 200,
                "data" => $products
               ];
                $this->view->response($response, 200);
            }else{
                $this->view->response("No hay productos en la base de datos", 404);
            }
        } catch (Exception $e) {
            $this->view->response("Error de servidor", 500);
        }
    }

    public function getProduct($params = null) {
        $id = $params[':ID'];
        try {
            $id = $this->model->getProduct($id);
            if($id){
                $response = [
                "status" => 200,
                "message" => $id
               ];
                $this->view->response($response, 200);
            }
            else{ 
                $response = [
                    "status" => 404,
                    "message" => "No existe el producto en la base de datos."
                ];
                $this->view->response($response, 404);
            }
        } catch (Exception $e) {

            $this->view->response("Error de servidor", 500);
        }

    }  
    
    public function addProduct() {
        try {
            $product = $this->getData();
            if (!isset($product->tipo) || !isset($product->descripcion) || !isset($product->precio) || !isset($product->talle) || !isset($product->id_tienda)) {
                $this->view->response("Complete los datos", 400);
            }else{
            $tipo=$product->tipo;
            $descripcion=$product->descripcion;
            $talle=$product->talle;
            $precio=$product->precio;
            $id_tienda=$product->id_tienda;
                $lastId=$this->model->addProduct($tipo, $descripcion, $talle, $precio, $id_tienda);
                $product=$this->model->getProduct($lastId);
                $response=[
                    "status" => 201,
                    "msg" => "Se agrego con éxito el producto con id $lastId",
                    "producto" => $product
                    ];
                    $this->view->response($response, 201);  
                }
        }catch(Exception $e) {
            $this->view->response("Error de servidor", 500);
        }
    }

    public function deleteProduct($params = null) {
      try {
        $id = $params[':ID'];
        $product = $this->model->getProduct($id);
        if ($product) {
            $this->model->deleteProduct($id);

            $this->view->response("Producto $id, eliminado", 200);
        } else {
            $this->view->response("Product $id, no encontrado", 404);
        }
    } catch (Exception $e) {
        $this->view->response("Error de servidor", 500);
    }
    }

    public function updateProduct($params = null) {
        try {
        $id = $params[':ID'];
        $editProd=$this->model->getProduct($id);
        if ($editProd) {
            $editProd = $this->getData();
            $tipo = $editProd->tipo;
            $descripcion = $editProd->descripcion; 
            $precio = $editProd->precio;
            $talle = $editProd->talle;           
            $id_tienda = $editProd->id_tienda;
            $this->model->updateProduct($tipo, $descripcion, $precio, $talle, $id_tienda, $id);
            $this->view->response("Producto $tipo, editado", 200);
        } else {
            $this->view->response("Producto $id, no encontrado", 404);
        }
    } catch (Exception $e) {
        $this->view->response("Error de servidor", 500);
    }
    }    
}