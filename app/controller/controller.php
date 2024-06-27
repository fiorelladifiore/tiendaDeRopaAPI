<?php
require_once 'app/view/JSONView.php';

class controller{
    protected $view;
    protected $data;

    public function __construct() {
        $this->view = new JSONView();
        $this->data = file_get_contents("php://input");
    }

    protected function getData() {
        return json_decode($this->data);
    }
}