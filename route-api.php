<?php
    require_once('libs/Router.php');
    require_once('app/controller/storesApiController.php');
    require_once('app/controller/authApiController.php');
    

    $router = new Router();

    // GET http://localhost/proyecto/tiendaDeRopaAPI/api/stores
    //api/stores?orderBy=telefono&orderDir=ASC
    $router->addRoute('stores', 'GET', 'storesApiController', 'showingStores');
    $router->addRoute('stores/:ID', 'GET', 'storesApiController', 'showingStore');
    $router->addRoute('stores', 'POST', 'storesApiController', 'newStore');
    $router->addRoute('stores/:ID', 'DELETE', 'storesApiController', 'deleteStore');
    $router->addRoute('stores/:ID', 'PUT', 'storesApiController', 'updateStore');
    $router->addRoute('auth', 'POST', 'authApiController', 'login');

    <?php
    require_once('libs/Router.php');
    require_once('app/controller/productsApiController.php');
    

    $router = new Router();

    // GET http://localhost/proyectos/tabajoAPI/api/products
    $router->addRoute('products', 'GET', 'productsApiController', 'getProducts');
    // obtener producto, 1 solo por id
    $router->addRoute('products/:ID', 'GET', 'productsApiController', 'getProduct');
    // agregar un producto
    $router->addRoute('product', 'POST', 'productsApiController', 'addProduct');
    // eliminar un producto
    $router->addRoute('product/:ID', 'DELETE', 'productsApiController', 'deleteProduct');
    // editar producto
    $router->addRoute('product/:ID', 'PUT', 'productsApiController', 'updateProduct');
    
    $router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);


