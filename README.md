# PROYECTO: TIENDA ALKEMY 🛒

Este proyecto reflejara las acciones que se pueden realizar sobre los diferentes recursos de una tienda.

## 🗺️RUTAS DE LA API:

### RUTAS/ENDPOINTS DE PRODUCTOS.

| Método | Ruta / Endpoint | Descripción
| -------------------------------------|
| `GET` | `/api/V1/productos` | Obtiene el listado completo de todos los productos y sus detalles |
| `GET` | `/api/V1/productos/{id}` | Obtiene el detalle de un producto específico |
| `POST` | `/api/V1/productos` | Crea un nuevo producto |
| `PUT` | `/api/V1/productos/{id}` | Actualiza un producto existente |
| `DELETE` | `/api/V1/productos/{id}` | Elimina un producto |

En el metodo POST para crear un nuevo producto se deben de enviar los siguientes valores:

{
    "nombre_producto": "Postaman Coca Cola",
    "descripcion_producto": "Una coca cola de Postman",
    "precio_producto": 18,
    "stock_producto": 12,
    "categoria_id": 1
}

En el metodo PUT para actualizar un producto se deben enviar al menos uno de los siguientes valores: 
{
    "nombre_producto": "Postaman Coca Cola",
    "descripcion_producto": "Una coca cola de Postman",
    "precio_producto": 18,
    "stock_producto": 12,
    "categoria_id": 1
}

Los valores mostrados que se pueden usar son ejemplos.

### RUTAS/ENDPOINTS DE CATEGORIAS.

| Método | Ruta / Endpoint | Descripción
| -------------------------------------|
| `GET` | `/api/V1/categorias` | Obtiene el listado completo de todas las categorias y sus detalles |
| `GET` | `/api/V1/categorias/{id}` | Obtiene el detalle de una categoria específica |
| `POST` | `/api/V1/categorias` | Crea un nuevo categoria |
| `PUT` | `/api/V1/categorias/{id}` | Actualiza una categoria existente |
| `DELETE` | `/api/V1/categorias/{id}` | Elimina una categoria |

En el metodo POST para crear una categoria se deben de enviar los siguientes valores: 

{
    "nombre_categoria": "Categoria Descartable",
    "descripcion_categoria": "Categoria con el fin de eliminarse."
}

En el metodo PUT para actualizar una categoria se deben de enviar al menos uno de estos valores:

{
    "nombre_categoria": "Categoria para pruebas de Postman 1.0",
    "descripcion_categoria": "Categoria para productos de Postman 1.0"
}

Los valores mostrados que se pueden usar son ejemplos.

### RUTAS/ENDPOINTS DE CARRITOS.

| Método | Ruta / Endpoint | Descripción
| -------------------------------------|
| `POST` | `/api/V1/carritos` | Crea un nuevo carrito |
| `DELETE` | `/api/V1/carritos/{id_carrito}`| Vacia todo el carrito |
| `GET` | `/api/V1/carritos/{id_carrito}/items`| Ver items de un carrito |
| `POST` | `/api/V1/carritos/{id_carrito}/items` | Agregar un producto al carrito |
| `DELETE` | `/api/V1/carritos/{id_carrito}/items/{id_producto}`| Elimina un producto de un carrito |
| `PUT` | `/api/V1/carritos/{id_carrito}/items/{id_producto}`| Actualiza la cantidad de un producto de un carrito. |

En el metodo POST para crear un carrito se deben enviar los siguientes valores: 

{
    "user_id": 1
}

En el metodo POST para agregar un producto al carrito se deben enviar los siguientes valores: 

{
    "producto_id": 2,
    "cantidad_producto": 4
}

En el metodo PUT para actualizar la cantidad de un producto en un carrito se deben mandar los siguientes valores:

{
    "cantidad_producto": 10
}

Los valores mostrados que se pueden usar son ejemplos.

### RUTAS/ENDPOINTS

| Método | Ruta / Endpoint | Descripción
| -------------------------------------|
| `GET` | `/api/V1/ordenes/{id}` | Ver resumen de una orden con todos sus detalles |
| `POST` | `/api/V1/carritos/`| Confirmar una orden |

En el metodo POST para confirmar la orden de x carrito se deben enviar los siguientes valores: 
{
    "carrito_id": 1,
    "direccion_envio": "Calle 6",
    "metodo_pago": "Tarjeta de credito"
}

Los valores mostrados que se pueden usar son ejemplos.

## REQUERIMIENTOS 🛠️

Los requerimientos son los siguientes:

Composer version 2.10.1.
Laravel Installer version 5.31.0.
PHP version 8.4.24.
Postman (para envio de solicitudes para el testeo).

Para ver tus versiones:
```shell
php -v
```
```shell
composer -v
```
```shell
laravel -v
```

## EJECUCION DEL PROYECTO 📑

- Posicionate en la carpeta de "htdocs" de Xampp. 
- Clona el repositorio mediante el siguiente comando el la terminal:
```shell
git clone https://github.com/TomasVelazque/Alkemy-3 .
```
- Copia el archivo de entorno .env.example a .env y configura los datos de tu base de datos:
```shell
cp .env.example .env
```
- Instala las dependencias de Composer:
```shell
composer install
```
- Genera la clave de la aplicación:
```shell
php artisan key:generate
```
- Ejecuta las migraciones y seeders:
```shell
php artisan migrate --seed
```
- Corre el servidor mediante (recuerda estar en la carpeta del proyecto): 
```shell
php artisan serve
```

¡Comienza a utilizar Postman para conocer y probar el flujo del programa!



