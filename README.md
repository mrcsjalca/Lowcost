<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Lowcost — CRUD Laravel + Bootstrap

Aplicación web de gestión de productos desarrollada con Laravel 12 y Bootstrap 5. Permite visualizar productos sin necesidad de registro, y gestionar el catálogo (crear, editar, eliminar) una vez autenticado.

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
git clone https://github.com/mrcsjalca/Lowcost.git
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

### 4. Configura la base de datos en `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lowcost
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Ejecuta las migraciones

```bash
php artisan migrate
```

### 6. Inicia el servidor

```bash
php artisan serve
```

Accede en: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Estructura de vistas

```
resources/views/
├── welcome.blade.php         # Página de inicio pública
├── productos/
│   ├── index.blade.php       # Listado de productos (público)
│   └── form.blade.php        # Formulario crear/editar (requiere login)
```

---

## Autenticación

El sistema usa Laravel Auth. Las rutas protegidas requieren login:

| Acción | Requiere login |
|--------|---------------|
| Ver productos |  No |
| Crear producto |  Sí |
| Editar producto |  Sí |
| Eliminar producto |  Sí |

---

## Modelo — Producto

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | integer | Clave primaria |
| `nombre` | string | Nombre del producto |
| `descripcion` | text | Descripción del producto |
| `precio` | decimal | Precio en euros (mín. 0) |
| `categoria` | string | Categoría del producto |
| `stock` | integer | Unidades disponibles (mín. 0) |
| `imagen` | string | Ruta de la imagen subida |

---

## Rutas principales

| Método | URL | Descripción |
|--------|-----|-------------|
| GET | `/` | Página de bienvenida |
| GET | `/productos` | Listado de productos |
| GET | `/productos/create` | Formulario de creación |
| POST | `/productos` | Guardar nuevo producto |
| GET | `/productos/{id}/edit` | Formulario de edición |
| POST | `/productos/{id}/update` | Actualizar producto |
| DELETE | `/productos/{id}` | Eliminar producto |

---

## Subida de imágenes

Las imágenes se guardan en `public/images/`. El campo acepta: `jpeg`, `png`, `jpg`, `gif`, `svg` con un máximo de 2MB.

---

## Validaciones

- El precio y el stock no pueden ser negativos.
- Los productos sin stock se muestran con badge rojo y la imagen en opacidad reducida.
- Si no hay productos, se muestra un mensaje informativo.

---

## Autor
**Marcos Jalca** - Desarrollado como proyecto de práctica con Laravel 12.
