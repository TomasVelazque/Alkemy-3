# 🛒 Tienda Alkemy: 5

API REST desarrollada en Laravel para gestionar una tienda de productos, con carritos de compra, órdenes y autenticación mediante JWT.

---

## 📋 Tabla de contenidos

- [Requerimientos](#-requerimientos)
- [Instalación](#-instalación)
- [Arquitectura](#-arquitectura)
- [Seguridad](#-seguridad)
- [Uso de la API](#-uso-de-la-api)
  - [Autenticación](#autenticación)
  - [Productos](#productos)
  - [Categorías](#categorías)
  - [Carritos](#carritos)
  - [Items del carrito](#items-del-carrito)
  - [Órdenes](#órdenes)
- [Testing](#-testing)

---

## 🛠️ Requerimientos

| Herramienta | Versión |
| :--- | :--- |
| PHP | 8.4.24 |
| Composer | 2.10.1 |
| Laravel Installer | 5.31.0 |
| Postman | (para probar el flujo de la API) |

Para verificar tus versiones instaladas:

```shell
php -v
composer -v
laravel -v
```

---

## 🚀 Instalación

1. Posicionate en la carpeta `htdocs` de XAMPP.

2. Cloná el repositorio:

```shell
git clone https://github.com/TomasVelazque/Alkemy-3 .
```

3. Copiá el archivo de entorno y configurá tu base de datos:

```shell
cp .env.example .env
```

4. Instalá las dependencias de Composer:

```shell
composer install
```

5. Generá la clave de la aplicación:

```shell
php artisan key:generate
```

6. Generá la clave secreta de JWT (necesaria para la autenticación):

```shell
php artisan jwt:secret
```

7. Ejecutá las migraciones y los seeders:

```shell
php artisan migrate --seed
```

8. Levantá el servidor:

```shell
php artisan serve
```

9. Importá la colección de Postman para probar los endpoints y conocer el flujo completo del sistema.

---

## 🏗️ Arquitectura

El proyecto sigue una organización en capas dentro de una API REST de Laravel, pensada para mantener los controladores livianos y la lógica de negocio testeable de forma aislada.

```
app/
├── Http/
│   ├── Controllers/Api/V1/   → Controladores de cada recurso (Producto, Categoria, Carrito, CarritoItem, Orden, Auth)
│   ├── Requests/              → Form Requests: validación de datos de entrada
│   └── Resources/             → API Resources: dan forma a las respuestas JSON
├── Services/                   → Lógica de negocio (ej. ProductoService)
├── DTO/                         → Data Transfer Objects (StoreProductoDTO, UpdateProductoDTO, etc.)
└── Models/                     → Modelos Eloquent (Producto, Categoria, Carrito, CarritoItem, Orden, User)
```

**Capas principales:**

- **Controladores**: reciben la request, delegan la validación al Form Request correspondiente y coordinan la respuesta. Todas las rutas están agrupadas bajo el prefijo `/api/V1`.
- **Services**: concentran la lógica de negocio que no pertenece al controlador (por ejemplo, la creación y actualización de productos), lo que permite testearla de forma aislada mediante mocks.
- **DTOs**: encapsulan y tipan los datos que viajan entre el controlador y el Service, evitando pasar arrays sueltos.
- **Resources**: transforman los modelos Eloquent al formato JSON final expuesto por la API, incluyendo el renombrado de campos y el formateo de fechas.
- **Modelos**: representan las tablas de la base de datos y sus relaciones (`Carrito` → `CarritoItem` → `Producto` → `Categoria`).

---

## 🔒 Seguridad

- **Autenticación:** basada en JWT sobre el guard `api`. Cada usuario recibe un access token al iniciar sesión, que debe enviarse en el header `Authorization: Bearer {token}` en cada request protegida.
- **Autorización por rol:** las rutas de creación, actualización y eliminación de **productos** y **categorías** están protegidas por un middleware `admin`, que solo permite el acceso a usuarios con permisos administrativos.
- **Propiedad de recursos:** en carritos e items del carrito se valida explícitamente que el recurso solicitado pertenezca al usuario autenticado, devolviendo `403 Forbidden` en caso contrario.
- **Rate limiting:** el listado y alta de productos está limitado mediante `throttle:10,1` (10 solicitudes por minuto) para mitigar abuso.
- **Validación de datos:** toda entrada pasa por un Form Request dedicado antes de llegar a la lógica de negocio.

---

## 📡 Uso de la API

Todas las rutas están prefijadas con `/api/V1`.

### Autenticación

| Método | Endpoint | Descripción | Auth |
| :--- | :--- | :--- | :--- |
| `POST` | `/login` | Inicia sesión y devuelve el access token | No |
| `POST` | `/register` | Registra un nuevo usuario | No |
| `GET` | `/profile` | Devuelve los datos del usuario autenticado | Sí |

### Productos

| Método | Endpoint | Descripción | Auth |
| :--- | :--- | :--- | :--- |
| `GET` | `/productos` | Lista todos los productos | No |
| `GET` | `/productos/{id}` | Detalle de un producto | No |
| `POST` | `/productos` | Crea un producto | Sí (admin) |
| `PUT` | `/productos/{id}` | Actualiza un producto | Sí (admin) |
| `DELETE` | `/productos/{id}` | Elimina un producto | Sí (admin) |

**Body para `POST /productos`:**

```json
{
    "nombre_producto": "Postaman Coca Cola",
    "descripcion_producto": "Una coca cola de Postman",
    "precio_producto": 18,
    "stock_producto": 12,
    "categoria_id": 1
}
```

**Body para `PUT /productos/{id}`** (al menos uno de los campos):

```json
{
    "nombre_producto": "Postaman Coca Cola",
    "descripcion_producto": "Una coca cola de Postman",
    "precio_producto": 18,
    "stock_producto": 12,
    "categoria_id": 1
}
```

### Categorías

| Método | Endpoint | Descripción | Auth |
| :--- | :--- | :--- | :--- |
| `GET` | `/categorias` | Lista todas las categorías | Sí (admin) |
| `GET` | `/categorias/{id}` | Detalle de una categoría | Sí (admin) |
| `POST` | `/categorias` | Crea una categoría | Sí (admin) |
| `PUT` | `/categorias/{id}` | Actualiza una categoría | Sí (admin) |
| `DELETE` | `/categorias/{id}` | Elimina una categoría | Sí (admin) |

**Body para `POST /categorias`:**

```json
{
    "nombre_categoria": "Categoria Descartable",
    "descripcion_categoria": "Categoria con el fin de eliminarse."
}
```

**Body para `PUT /categorias/{id}`** (al menos uno de los campos):

```json
{
    "nombre_categoria": "Categoria para pruebas de Postman 1.0",
    "descripcion_categoria": "Categoria para productos de Postman 1.0"
}
```

### Carritos

| Método | Endpoint | Descripción | Auth |
| :--- | :--- | :--- | :--- |
| `POST` | `/carritos` | Crea un nuevo carrito | Sí |
| `DELETE` | `/carritos/{id_carrito}` | Vacía todo el carrito | Sí |

**Body para `POST /carritos`:**

```json
{
    "user_id": 1
}
```

### Items del carrito

| Método | Endpoint | Descripción | Auth |
| :--- | :--- | :--- | :--- |
| `GET` | `/carritos/{id_carrito}/items` | Lista los items de un carrito | Sí |
| `POST` | `/carritos/{id_carrito}/items` | Agrega un producto al carrito | Sí |
| `PUT` | `/carritos/{id_carrito}/items/{id_producto}` | Actualiza la cantidad de un producto | Sí |
| `DELETE` | `/carritos/{id_carrito}/items/{id_producto}` | Elimina un producto del carrito | Sí |

**Body para `POST /carritos/{id_carrito}/items`:**

```json
{
    "producto_id": 2,
    "cantidad_producto": 4
}
```

**Body para `PUT /carritos/{id_carrito}/items/{id_producto}`:**

```json
{
    "cantidad_producto": 10
}
```

> Si el producto ya existe en el carrito, la cantidad enviada se **suma** a la ya existente en lugar de crear un nuevo item.

### Órdenes

| Método | Endpoint | Descripción | Auth |
| :--- | :--- | :--- | :--- |
| `GET` | `/ordenes/{id}` | Resumen de una orden con todos sus detalles | Sí |
| `POST` | `/ordenes` | Confirma una orden a partir de un carrito | Sí |

**Body para `POST /ordenes`:**

```json
{
    "carrito_id": 1,
    "direccion_envio": "Calle 6",
    "metodo_pago": "Tarjeta de credito"
}
```

> Los valores mostrados en todos los ejemplos son a modo ilustrativo.

---

## ✅ Testing

El proyecto usa **PHPUnit** con `RefreshDatabase` para aislar cada test en una base de datos limpia.

### Correr toda la suite

```shell
php artisan test
```

### Correr solo una clase de test

```shell
php artisan test --filter=NombreDeLaClase
```