<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lowcost</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<nav class="navbar bg-white border-bottom px-4">
    <a href="/">
        <img src="https://i.pinimg.com/736x/54/36/68/543668b027f5e8456104c6088137f7b1.jpg" height="45" style="border-radius:8px;">
    </a>
    <div class="d-flex gap-2">
        @guest
            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="btn btn-dark btn-sm">Registrarse</a>
        @else
            <span class="align-self-center text-muted small">Hola, {{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-secondary btn-sm">Cerrar sesión</button>
            </form>
        @endauth
    </div>
</nav>

<section class="text-center py-5 flex-grow-1">
    <h1 class="fw-bold">Bienvenido a Lowcost</h1>
    <p class="text-muted">Encuentra los productos que te gustan tanto. Calidad mediocre y precios iguales.</p>
    <a href="{{ route('productos.index') }}" class="btn btn-dark px-4 py-2">Ver productos</a>
</section>

<div class="container pb-5">
    <div class="row justify-content-center g-3" style="max-width:700px; margin:auto;">
        <div class="col-md-4">
            <div class="card text-center p-3">
                <img src="https://i.pinimg.com/736x/91/27/b5/9127b546426024c84d24ca3b5f24315a.jpg" class="mx-auto mb-2" style="width:80px;height:80px;object-fit:cover;border-radius:12px;">
                <h6 class="fw-semibold">Envío lentillo</h6>
                <p class="text-muted small">Recibe tu pedido en 24-48 años</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <img src="https://i.pinimg.com/736x/98/27/6f/98276f3e1d4706c8be0fbd17bb748e9f.jpg" class="mx-auto mb-2" style="width:80px;height:80px;object-fit:cover;border-radius:12px;">
                <h6 class="fw-semibold">Precio variable</h6>
                <p class="text-muted small">Garantizamos el precio más bajo (o no)</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <img src="https://i.pinimg.com/736x/e6/73/1e/e6731e84b4e4082ad9f4772ba443d182.jpg" class="mx-auto mb-2" style="width:80px;height:80px;object-fit:cover;border-radius:12px;">
                <h6 class="fw-semibold">Compra segura</h6>
                <p class="text-muted small">El dinero me va a llegar a mi 100%</p>
            </div>
        </div>
    </div>
</div>

<footer class="bg-white border-top text-center py-3 text-muted small">
    2025 Lowcost — Todos los derechos para mi y 0 devoluciones
</footer>

</body>
</html>