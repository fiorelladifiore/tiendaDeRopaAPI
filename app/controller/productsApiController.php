<?php
require_once('app/model/productsModel.php');
require_once('app/view/JSONView.php');

class productsApiController {

    private $model;
    private $view;
    private $data;

    public function __construct() {
        $this->model = new productsModel();
        $this->view = new JSONView();

        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function getProducts() {
        try {
            // Obtener todas las tareas del modelo
            $products = $this->model->getAll();
            if($products){
                $response = [
                "status" => 200,
                "data" => $products
               ];
                $this->view->response($response, 200);
                // Si hay productos, devolverlas con un código 200 (éxito)
            }
            else
                $this->view->response("No hay productos en la base de datos", 404);
                 // Si no hay productos, devolver un mensaje con un código 404 (no encontrado)
        } catch (Exception $e) {
            // En caso de error del servidor, devolver un mensaje con un código 500 (error del servidor)
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
            // En caso de error del servidor, devolver un mensaje con un código 500 (error del servidor)
            $this->view->response("Error de servidor", 500);
        }

    }  
    
    public function addProduct() {
        try {
    $newProduct = $this->getData();
    $lastId = $this->model->addProduct(
        $newProduct->tipo, 
        $newProduct->descripcion, 
        $newProduct->talle,
//        $newProduct->imagen,
        $newProduct->id_tienda, 
        $newProduct->precio);
        
        if(empty($tipo)|| empty($descripcion)|| empty($talle)|| empty($id_tienda)||empty($precio)){
            $this->view->response("Completar los datos faltantes", 400);
        }else{
            $lastId=$this->model->addProduct($tipo, $descripcion , $talle, $id_tienda, $precio);
            $product=$this->model->getProduct($lastId);
            $response = [
                "status" => 201,
                "msg" => "Se agrego con exito el producto con id $lastId",
                "product" => $product,
            ]; 
            $this->view->response($response, 201);
        }
    } catch (Exception $e) {
        $this->view->response("Error de servidor", 500);
    }
        
    }

    public function deleteProduct($params = null) {
      try {
        $id = $params[':ID'];
        $product = $this->model->getProd($id);
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
     $editProd=$this->model->getProd($id);
        if ($editProd) {
            $editProd = $this->getData();
            $tipo = $editProd->tipo;
            $descripcion = $editProd->descripcion; 
            $precio = $editProd->precio;
            $talle = $editProd->talle;           
            $this->model->updateProduct($tipo, $descripcion, $talle, $precio, $id);

            $this->view->response("Producto $tipo, editado", 200);
        } else {
            $this->view->response("Producto $id, no encontrado", 404);
        }
    } catch (Exception $e) {
        $this->view->response("Error de servidor", 500);
    }
    }    
}