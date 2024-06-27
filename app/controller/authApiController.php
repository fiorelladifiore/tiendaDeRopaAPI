<?php
require_once 'app/model/authModel.php';
require_once 'app/controller/controller.php';

class authApiController extends controller{
    private $model;

    public function __construct() {
        parent::__construct();
        $this->model = new authModel();
    }

    public function login(){
        try {
        $user = $this->getData();
            $username = $this->model->getUser($user->user);
                if ($username && password_verify($user->password, $username->password)) {
                    $this->view->response($user, 200);
                } else {
                    $this->view->response("Usuario o contraseña incorrectos", 404);
                }
            }catch(Exception $e) {
                $this->view->response("Error de servidor", 500);
            }
    }




}


