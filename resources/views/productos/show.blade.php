<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $producto->nombre }} - Lowcost</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-light bg-white border-bottom px-4">
    <a class="navbar-brand" href="/">
        <img src="https://i.pinimg.com/736x/54/36/68/543668b027f5e8456104c6088137f7b1.jpg" 
             height="45" style="border-radius:8px;">
    </a>
    <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary btn-sm">← Volver</a>
</nav>

<div class="container py-5" style="max-width:800px;">
    <div class="card shadow-sm">
        <div class="row g-0">

            <div class="col-md-5">
                @if($producto->imagen)
                    <img src="{{ asset($producto->imagen) }}"
                         class="img-fluid rounded-start {{ $producto->stock <= 0 ? 'opacity-50' : '' }}"
                         style="height:100%; object-fit:cover; max-height:400px; width:100%;">
                @else
                    <div class="bg-secondary d-flex align-items-center justify-content-center rounded-start" style="height:400px;">
                        <img src="https://i.pinimg.com/736x/29/8a/bd/298abd4daba8261a35ac2b8b55963519.jpg"
                             style="width:150px; height:150px; object-fit:cover; border-radius:12px;">
                    </div>
                @endif
            </div>

            <div class="col-md-7">
                <div class="card-body p-4">
                    <h2 class="fw-bold mb-1">{{ $producto->nombre }}</h2>
                    <p class="text-muted small mb-3">{{ $producto->categoria }}</p>

                    <p class="fs-3 fw-bold text-success mb-1">{{ number_format($producto->precio, 2) }} €</p>

                    @if($producto->stock <= 0)
                        <span class="badge bg-danger mb-3">Sin stock</span>
                    @else
                        <span class="badge bg-success mb-3">Stock disponible: {{ $producto->stock }}</span>
                    @endif

                    <hr>

                    <h6 class="fw-semibold">Descripción</h6>
                    <p class="text-muted">{{ $producto->descripcion }}</p>

                    <hr>

                    <div class="d-flex gap-2 flex-wrap mt-3">

                        @auth
                            @if(Auth::user()->email !== env('ADMIN_EMAIL') && $producto->stock > 0)
                                @php
                                    $carrito = session()->get('carrito', []);
                                    $cantidadEnCarrito = isset($carrito[$producto->id]) ? $carrito[$producto->id]['cantidad'] : 0;
                                @endphp
                                <div class="d-flex align-items-center gap-2">
                                    @if($cantidadEnCarrito > 0)
                                        <form method="POST" action="{{ route('carrito.reducir', $producto->id) }}">
                                            @csrf
                                            <button class="btn btn-outline-secondary btn-sm px-3">−</button>
                                        </form>
                                        <span class="fw-bold">{{ $cantidadEnCarrito }}</span>
                                    @endif
                                    @if($cantidadEnCarrito < $producto->stock)
                                        <form method="POST" action="{{ route('carrito.agregar', $producto->id) }}">
                                            @csrf
                                        </form>
                                    @else
                                        <span class="text-danger small fw-bold">Stock máximo alcanzado</span>
                                    @endif
                                </div>
                            @endif

                            @if(Auth::user()->email === env('ADMIN_EMAIL'))
                                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form method="POST" action="{{ route('productos.destroy', $producto->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                                </form>
                            @endif
                        @else
                            @guest
                                @if($producto->stock > 0)
                                    <a href="{{ route('login') }}" class="btn btn-dark btn-sm">Iniciar sesión para comprar</a>
                                @endif
                            @endguest
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>