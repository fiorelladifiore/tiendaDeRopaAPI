## Índice
1. [storesApiController](#documentación-storesapicontroller)
    - [Función `showingStores()`](#función-showingstores)
    - [Función `showingStore()`](#función-showingstore)
    - [Función `newStore()`](#función-newstore)
    - [Función `deleteStore()`](#función-deletestore)
    - [Función `updateStore()`](#función-updatestore)


___

# Documentación `storesApiController`
## Introducción
El storesApiController es una clase encargada de manejar las solicitudes relacionadas con las tiendas dentro de nuestra aplicación. Actúa como un intermediario entre el cliente y el modelo de datos, proporcionando una interfaz para interactuar con las tiendas a través de varias operaciones CRUD (Crear, Leer, Actualizar, Eliminar). El objetivo principal del storesApiController es facilitar una gestión eficiente y organizada de las tiendas, garantizando que todas las operaciones se realicen de manera coherente y segura.
A continuación se detallan cada una de sus funciones.

## Función `showingStores()`

### Descripción
La función `showingStores` del controlador obtiene todas las tiendas de la base de datos y envía una respuesta adecuada al cliente basado en el resultado. Además, se encarga de enviar parámetros de ordenación en caso de que los haya.

### CÓDIGO ESCRITO A MANO (COPY - PASTE DEL CONTROLADOR)

```php
 public function showingStores() {
        try {
            //se asigna un orden predeterminado en caso de que no haya parámetros.
            $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'nombre';
            $orderDir = isset($_GET['orderDir']) ? strtoupper($_GET['orderDir']) : 'ASC';
            //Verifica que si no se inserta una dirección válida, use una predeterminada.
            if ($orderDir != 'ASC' && $orderDir != 'DESC') {
                $orderDir = 'ASC';
            }
            $stores = $this->model->getAll($orderBy, $orderDir);
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
```

### Retorno
La función no retorna ningún valor directamente. En su lugar, envía una respuesta al cliente utilizando el objeto `view`. Los posibles códigos de estado de respuesta son:

- **200 OK:** Si se obtuvieron tiendas correctamente.
- **404 Not Found:** Si no hay tiendas en la base de datos.
- **500 Internal Server Error:** Si ocurre un error del servidor al intentar obtener las tiendas.

## Ejemplos de uso `GET http://localhost/proyecto/tiendaDeRopaAPI/api/stores`
### Ejemplo 1: Cómo obtener todas las tiendas

Si hay tiendas en la base de datos, la función enviará una respuesta con código 200 y las tiendas en formato JSON:
```json
{
    "status": 200,
    "data": [
        {
        "id_tienda": 1,
        "nombre": "urban clothing CA",
        "direccion": "arce 500",
        "telefono": 22783887,
        "email": "urbanclothingca@gmail.com"
        },
        ...
    ]
}
```

### Ejemplo 2: tiendas no encontradas

Si no existen tiendas en la base de datos, la función enviará una respuesta con código 404 y un mensaje de error:
```json
{
   {
    "status": 404,
    "message": "No existen tiendas en la base de datos"
   }
}
```

### Ejemplo 3: Error de servidor

Si ocurre un error del servidor, la función enviará una respuesta con código 500 y un mensaje de error:

```json
{
    "status": 500,
    "message": "Error de servidor"
}
```

### Notas 

- **La inclusión del mensaje de excepción (`$e->getMessage()`) en la respuesta de error del servidor puede ser útil para depuración, pero puede exponer detalles sensibles del servidor. Considera esta práctica con cuidado, especialmente en entornos de producción.** 
- **Asegúrate de manejar adecuadamente las excepciones y errores en el modelo y la vista para evitar problemas inesperados.** 



___

## Función `showingStore()`

### Descripción
La función `showingStore` del controlador obtiene una tienda específica de la base de datos mediante el ID y envía una respuesta adecuada al cliente basado en el resultado.

### CÓDIGO ESCRITO A MANO (COPY - PASTE DEL CONTROLADOR)

```php
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
```
### Parámetros
**`$params (array)`: Un array asociativo que contiene los parámetros de la solicitud. En este caso, se espera que contenga '`:ID`', el identificador de la tienda que se desea obtener.**

### Retorno
La función no retorna ningún valor directamente. En su lugar, envía una respuesta al cliente utilizando el objeto `view`. Los posibles códigos de estado de respuesta son:

- **200 OK:** Si se obtuvo la tienda correctamente.
- **404 Not Found:** Si no existe tienda solicitada en la base de datos.
- **500 Internal Server Error:** Si ocurre un error del servidor al intentar obtener la tienda.

## Ejemplos de uso `GET http://localhost/proyecto/tiendaDeRopaAPI/api/stores/3`
### Ejemplo 1: Cómo obtener una tienda

Si existe la tienda solicitada en la base de datos, la función enviará una respuesta con código 200 y la tienda en formato JSON:
```json
{
    "status": 200,
    "data": [
        {
        "id_tienda": 3,
        "nombre": "Urban clothing SF",
        "direccion": "Alvear 678",
        "telefono": 342413982,
        "email": "urbanclothingsf@gmail.com"
        },
        ...
    ]
}
```

### Ejemplo 2: tienda no encontrada

Si no existe la tienda demandada en la base de datos, la función enviará una respuesta con código 404 y un mensaje de error:
```json
{
   {
    "status": 404,
    "message": "No existe la tienda en la base de datos."
   }
}
```

### Ejemplo 3: Error de servidor

Si ocurre un error del servidor, la función enviará una respuesta con código 500 y un mensaje de error:

```json
{
    "status": 500,
    "message": "Error de servidor"
}
```

### Notas 

- **La inclusión del mensaje de excepción (`$e->getMessage()`) en la respuesta de error del servidor puede ser útil para depuración, pero puede exponer detalles sensibles del servidor. Considera esta práctica con cuidado, especialmente en entornos de producción.** 
- **Asegúrate de manejar adecuadamente las excepciones y errores en el modelo y la vista para evitar problemas inesperados.** 




___

## Función `newStore()`

### Descripción
La función `newStore` del controlador agrega una nueva tienda y envía una respuesta adecuada al cliente basado en el resultado.

### CÓDIGO ESCRITO A MANO (COPY - PASTE DEL CONTROLADOR)

```php
 public function newStore() {
        try {
        $store = $newStore = $this->getData();
        $nombre=$store->nombre;
        $direccion=$store->direccion;
        $telefono=$store->telefono;
        $email=$store->email;
        //verifica que los campos se encuentren completos
        if (empty($nombre) || empty($direccion) || empty($telefono) || empty($email)) {
                $this->view->response("Complete los datos", 400);
            }else{
                $lastId=$this->model->insertStore($nombre, $direccion, $telefono, $email);
                $store=$this->model->getStore($lastId);
                $this->view->response($store, 201);  
            }
        }catch(Exception $e) {
            $this->view->response("Error de servidor", 500);
        }
    }

```

### Retorno
La función no retorna ningún valor directamente. En su lugar, envía una respuesta al cliente utilizando el objeto `view`. Los posibles códigos de estado de respuesta son:

- **201 Created:** Si se creó la tienda correctamente.
- **400 Bad request:** Si hubo error en la solicitud de agregar la tienda.
- **500 Internal Server Error:** Si ocurre un error del servidor al intentar añadir la tienda.

## Ejemplos de uso `POST http://localhost/proyectos/tiendaDeRopaAPI/api/stores/`

### Ejemplo 1: Creación exitosa de la tienda

Si la tienda fue agregada correctamente, la función enviará una respuesta con código 201:
```json
 {
    "id_tienda": 1,
    "nombre": "urban clothing CA",
    "direccion": "Velez 500",
    "telefono": 22783887,
    "email": "urbanclothingca@gmail.com"
}
```

### Ejemplo 2: Error en la solicitud al agregar la tienda

Si la tienda que se intentó añadir no logra concretarse, la función enviará una respuesta con código 400 y un mensaje de error:
```json
{
   {
    "status": 400,
    "message": "Complete los datos"
   }
}
```

### Ejemplo 3: Error de servidor

Si ocurre un error del servidor, la función enviará una respuesta con código 500 y un mensaje de error:

```json
{
    "status": 500,
    "message": "Error de servidor"
}
```

### Notas 

- **La inclusión del mensaje de excepción (`$e->getMessage()`) en la respuesta de error del servidor puede ser útil   para depuración, pero puede exponer detalles sensibles del servidor. Considera esta práctica con cuidado, especialmente en entornos de producción.** 
- **Asegúrate de manejar adecuadamente las excepciones y errores en el modelo y la vista para evitar problemas inesperados.** 



___

## Función `deleteStore()`

### Descripción
La función `deleteStore` del controlador recibe el ID de una tienda para posteriormente eliminarla y envía una respuesta adecuada al cliente basado en el resultado.

### CÓDIGO ESCRITO A MANO (COPY - PASTE DEL CONTROLADOR)

```php
  public function deleteStore($params = null) {
        try{
        $id = $params[':ID'];
        $store = $this->model->getStore($id);
        if ($store) {
            $this->model->deleteStore($id);

            $this->view->response("Tienda $id, eliminada", 200);
        } else {
            $this->view->response("Tienda $id, no encontrada", 404);
            }
        }catch(Exception $e) {
        $this->view->response("Error de servidor", 500);
            }
        }
```
### Parámetros
**`$params (array)`: Un array asociativo que contiene los parámetros de la solicitud. En este caso, se espera que contenga '`:ID`', el identificador de la tienda que se desea obtener.**

### Retorno
La función no retorna ningún valor directamente. En su lugar, envía una respuesta al cliente utilizando el objeto `view`. Los posibles códigos de estado de respuesta son:

- **200 OK:** Si se eliminó la tienda correctamente.
- **404 Not Found:** Si no existe una tienda con el ID dado en la base de datos.
- **500 Internal Server Error:** Si ocurre un error del servidor al intentar obtener la tienda.

## Ejemplos de uso `DELETE http://localhost/proyecto/tiendaDeRopaAPI/api/stores/3`
### Ejemplo 1: Cómo eliminar una tienda

Si la tienda solicitada existe en la base de datos, la función enviará una respuesta con código 200:
```json
"Tienda 3, eliminada"
```

### Ejemplo 2: Tienda no encontrada

Si no existe la determinada tienda en la base de datos, la función enviará una respuesta con código 404 y un mensaje de error:
```json
{
   {
    "status": 404,
    "message": "No existe la tienda en la base de datos"
   }
}
```

### Ejemplo 3: Error de servidor

Si ocurre un error del servidor, la función enviará una respuesta con código 500 y un mensaje de error:

```json
{
    "status": 500,
    "message": "Error de servidor"
}
```

### Notas 

- **La inclusión del mensaje de excepción (`$e->getMessage()`) en la respuesta de error del servidor puede ser útil para depuración, pero puede exponer detalles sensibles del servidor. Considera esta práctica con cuidado, especialmente en entornos de producción.** 
- **Asegúrate de manejar adecuadamente las excepciones y errores en el modelo y la vista para evitar problemas inesperados.** 



___

## Función `updateStore()`

### Descripción
La función `updateStore` del controlador recibe un ID de una tienda de la base de datos para modificar los atributos de esta y envía una respuesta adecuada al cliente basado en el resultado.

### CÓDIGO ESCRITO A MANO (COPY - PASTE DEL CONTROLADOR)

```php
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
```
### Parámetros
**`$params (array)`: Un array asociativo que contiene los parámetros de la solicitud. En este caso, se espera que contenga '`:ID`', el identificador de la tienda que se desea obtener.**

### Retorno
La función no retorna ningún valor directamente. En su lugar, envía una respuesta al cliente utilizando el objeto `view`. Los posibles códigos de estado de respuesta son:

- **200 OK:** Si se editó la tienda correctamente.
- **404 Not Found:** Si no existe la tienda en la base de datos.
- **500 Internal Server Error:** Si ocurre un error del servidor al intentar editar la tienda.

## Ejemplos de uso `PUT http://localhost/proyecto/tiendaDeRopaAPI/api/stores/3`
### Ejemplo 1: Cómo obtener la tienda editada

Si la tienda elegida existe en la base de datos, la función enviará una respuesta con código 200:
```json
"Tienda urban clothing Cba, modificada"
```

### Ejemplo 2: Tienda no encontrada

Si no existe la tienda en la base de datos, la función enviará una respuesta con código 404 y un mensaje de error:
```json
{
   {
    "status": 404,
    "message": "Tienda urban clothing Cba, no encontrada"
   }
}
```

### Ejemplo 3: Error de servidor

Si ocurre un error del servidor, la función enviará una respuesta con código 500 y un mensaje de error:

```json
{
    "status": 500,
    "message": "Error de servidor"
}
```

### Notas 

- **La inclusión del mensaje de excepción (`$e->getMessage()`) en la respuesta de error del servidor puede ser útil para depuración, pero puede exponer detalles sensibles del servidor. Considera esta práctica con cuidado, especialmente en entornos de producción.** 
- **Asegúrate de manejar adecuadamente las excepciones y errores en el modelo y la vista para evitar problemas inesperados.** 




___

## Requisitos y notas adicionales
- Modelo de tienda debe implementar los siguientes métodos `showingStores`, `showingStore`, `newStore`, `deleteStore`, `updateStore`.
- Vista que implemente el método `response`.
