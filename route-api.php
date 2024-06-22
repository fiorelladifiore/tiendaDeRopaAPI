<?php
    require_once('libs/Router.php');
    require_once('app/controller/storesApiController.php');
    

    $router = new Router();

    // GET http://localhost/proyecto/tiendaDeRopaAPI/api/stores
    $router->addRoute('stores', 'GET', 'storesApiController', 'showingStores');
    $router->addRoute('stores/:ID', 'GET', 'storesApiController', 'showingStore');
    $router->addRoute('stores', 'POST', 'storesApiController', 'newStore');
    $router->addRoute('stores/:ID', 'DELETE', 'storesApiController', 'deleteStore');
    $router->addRoute('stores/:ID', 'PUT', 'storesApiController', 'updateStore');

    $router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);


