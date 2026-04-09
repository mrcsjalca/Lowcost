<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Lowcost — Tienda Online Laravel + Bootstrap
 
Aplicación web de tienda online desarrollada con Laravel 12 y Bootstrap 5. Permite a cualquier visitante ver los productos, y a los usuarios registrados añadirlos al carrito y comprarlos con saldo ficticio. Solo el administrador puede gestionar el catálogo y los saldos.
 
---
 
## Tecnologías
 
- **PHP** 8.2.4
- **Laravel** 12.56.0
- **Bootstrap** 5.3
- **MySQL** (via XAMPP)
- **Blade** (motor de plantillas de Laravel)
 
---
 
## Instalación
 
### 1. Clona el repositorio
 
```bash
git clone https://github.com/tu-usuario/crudlaravelbootstrap.git
cd crudlaravelbootstrap
```
 
### 2. Instala las dependencias
 
```bash
composer install
```
 
### 3. Copia el archivo de entorno
 
```bash
cp .env.example .env
php artisan key:generate
```
 
### 4. Configura la base de datos y el admin en `.env`
 
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lowcost
DB_USERNAME=root
DB_PASSWORD=
 
ADMIN_EMAIL=admin@lowcost.com
ADMIN_PASSWORD=1234
```
 
### 5. Ejecuta las migraciones
 
```bash
php artisan migrate
```
 
### 6. Crea el usuario administrador
 
```bash
php artisan db:seed --class=AdminSeeder
```
 
### 7. Inicia el servidor
 
```bash
php artisan serve
```
 
Accede en: [http://127.0.0.1:8000](http://127.0.0.1:8000)
 
---
 
## Estructura de vistas
 
```
resources/views/
├── welcome.blade.php              # Página de inicio pública
├── productos/
│   ├── index.blade.php            # Listado de productos (público)
│   ├── show.blade.php             # Detalle de producto (público)
│   └── form.blade.php             # Formulario crear/editar (solo admin)
├── carrito/
│   ├── index.blade.php            # Vista del carrito
│   └── resumen.blade.php          # Resumen tras finalizar compra
└── saldo/
    └── index.blade.php            # Gestión de saldo (solo admin)
```
 
---
 
## Roles y permisos
 
| Acción | Sin login | Usuario | Admin |
|--------|-----------|---------|-------|
| Ver productos | ✅ | ✅ | ✅ |
| Ver detalle producto | ✅ | ✅ | ✅ |
| Ver carrito | ✅ | ✅ | ✅ |
| Añadir al carrito | ❌ (redirige a login) | ✅ | ❌ |
| Finalizar compra | ❌ | ✅ | ❌ |
| Crear producto | ❌ | ❌ | ✅ |
| Editar producto | ❌ | ❌ | ✅ |
| Eliminar producto | ❌ | ❌ | ✅ |
| Gestionar saldos | ❌ | ❌ | ✅ |
 
---
 
## Modelo — Producto
 
| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | integer | Clave primaria |
| `nombre` | string | Nombre del producto |
| `descripcion` | text | Descripción detallada |
| `precio` | decimal | Precio en euros (mín. 0) |
| `categoria` | string | Categoría del producto |
| `stock` | integer | Unidades disponibles (mín. 0) |
| `imagen` | string | Ruta de la imagen subida |
 
---
 
## Modelo — User
 
| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | integer | Clave primaria |
| `name` | string | Nombre del usuario |
| `email` | string | Email único |
| `password` | string | Contraseña cifrada |
| `saldo` | decimal | Saldo ficticio disponible (mín. 0) |
 
---
 
## Rutas principales
 
| Método | URL | Descripción |
|--------|-----|-------------|
| GET | `/` | Página de bienvenida |
| GET | `/productos` | Listado de productos |
| GET | `/productos/{id}` | Detalle de producto |
| GET | `/productos/create` | Formulario creación (admin) |
| POST | `/productos` | Guardar producto (admin) |
| GET | `/productos/{id}/edit` | Formulario edición (admin) |
| POST | `/productos/{id}/update` | Actualizar producto (admin) |
| DELETE | `/productos/{id}` | Eliminar producto (admin) |
| GET | `/carrito` | Ver carrito |
| POST | `/carrito/agregar/{id}` | Añadir producto al carrito |
| POST | `/carrito/reducir/{id}` | Reducir cantidad en carrito |
| DELETE | `/carrito/eliminar/{id}` | Eliminar producto del carrito |
| POST | `/carrito/vaciar` | Vaciar carrito completo |
| POST | `/carrito/finalizar` | Finalizar compra |
| GET | `/carrito/resumen` | Resumen de compra |
| GET | `/saldo` | Gestión de saldos (admin) |
| POST | `/saldo/{user}` | Asignar saldo a usuario (admin) |
 
---
 
## Sistema de carrito
 
- El carrito se guarda en **sesión** (se pierde al cerrar el navegador).
- Al añadir un producto, se comprueba que no supere el **stock disponible**.
- El contador `+` / `−` aparece en cada tarjeta de producto.
- Cuando se alcanza el máximo de stock disponible, el botón `+` se reemplaza por "Máx."
- Al finalizar la compra se valida:
  - Que el usuario tenga **saldo suficiente**.
  - Que haya **stock** de cada producto.
- Si todo es correcto, se descuenta el saldo y el stock, y se muestra el resumen.
 
---
 
## Sistema de saldo ficticio
 
- El admin asigna saldo a cada usuario desde `/saldo`.
- El saldo se muestra en el navbar al estar logueado.
- Si no hay saldo suficiente al finalizar la compra, se muestra un error y no se procesa.
 
---
 
## Validaciones
 
- Precio y stock no pueden ser negativos (`min:0`).
- Productos sin stock se muestran con borde rojo e imagen en opacidad reducida.
- No se puede añadir más cantidad al carrito de la que hay en stock.
- Si no hay productos, se muestra un mensaje informativo.
 
---
 
## Subida de imágenes
 
Las imágenes se guardan en `public/images/`. Formatos aceptados: `jpeg`, `png`, `jpg`, `gif`, `svg`. Tamaño máximo: 2MB.
 
---

## Autor
**Marcos Jalca** - Desarrollado como proyecto de práctica con Laravel 12.
