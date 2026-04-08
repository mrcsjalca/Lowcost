<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Lowcost</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-light bg-white border-bottom px-4">
    <a class="navbar-brand d-flex align-items-center gap-2" href="/">
        <img src="https://i.pinimg.com/736x/54/36/68/543668b027f5e8456104c6088137f7b1.jpg" 
             alt="Lowcost" style="height: 45px; border-radius: 8px;">
    </a>
    <div class="d-flex gap-2 align-items-center">
        @guest
            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="btn btn-dark btn-sm">Registrarse</a>
        @else
            <span class="text-muted small">Hola, {{ Auth::user()->name }}</span>
            <span class="fw-bold text-success small">{{ number_format(Auth::user()->saldo, 2) }} €</span>
            @if(Auth::user()->email === env('ADMIN_EMAIL'))
                <a href="{{ route('productos.create') }}" class="btn btn-success btn-sm">+ Nuevo producto</a>
                <a href="{{ route('saldo.index') }}" class="btn btn-warning btn-sm">Saldos</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button class="btn btn-outline-secondary btn-sm">Cerrar sesión</button>
            </form>
        @endguest
        <a href="{{ route('carrito.index') }}" class="btn btn-outline-dark btn-sm">
            Carrito
            @php $totalItems = array_sum(array_column(session()->get('carrito', []), 'cantidad')); @endphp
            @if($totalItems > 0)
                <span class="badge bg-danger">{{ $totalItems }}</span>
            @endif
        </a>
    </div>
</nav>

<div class="container py-5">
    <h2 class="mb-4 fw-bold">Todos los productos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($productos->isEmpty())
        <div class="text-center py-5">
            <img src="https://i.pinimg.com/1200x/e3/7f/82/e37f829fb46f4d63828b8d30a872429e.jpg" 
                style="width:150px; height:150px; object-fit:cover; border-radius:12px;">
            <p class="text-muted mt-3">No hay productos ahora mismo, peldon</p>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($productos as $producto)
            <div class="col">
                <div class="card h-100 shadow-sm {{ $producto->stock <= 0 ? 'border-danger' : '' }}">

                    @if($producto->imagen)
                        <img src="{{ asset($producto->imagen) }}" class="card-img-top {{ $producto->stock <= 0 ? 'opacity-50' : '' }}" style="height:200px; object-fit:cover;">
                    @else
                        <div class="bg-secondary d-flex align-items-center justify-content-center" style="height:200px;">
                            <img src="https://i.pinimg.com/736x/29/8a/bd/298abd4daba8261a35ac2b8b55963519.jpg" alt="Sin imagen"
                                style="width:150px; height:150px; object-fit:cover; border-radius:12px;">
                        </div>
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <p class="text-muted small">{{ $producto->categoria }}</p>
                        <p class="card-text small">{{ Str::limit($producto->descripcion, 80) }}</p>
                        <p class="fw-bold text-success fs-5">{{ number_format($producto->precio, 2) }} €</p>
                        @if($producto->stock <= 0)
                            <span class="badge bg-danger">Sin stock</span>
                        @else
                            <span class="badge bg-success">Stock: {{ $producto->stock }}</span>
                        @endif

    
                    </div>

                    <div class="card-footer d-flex gap-2 flex-wrap align-items-center">

                        @if($producto->stock > 0)
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-dark btn-sm">Añadir al carrito</a>
                            @else
                                @if(Auth::user()->email !== env('ADMIN_EMAIL'))  {{-- ✅ oculta al admin --}}
                                    @php
                                        $carrito = session()->get('carrito', []);
                                        $cantidadEnCarrito = isset($carrito[$producto->id]) ? $carrito[$producto->id]['cantidad'] : 0;
                                    @endphp
                                    <div class="d-flex align-items-center gap-1">
                                        @if($cantidadEnCarrito > 0)
                                            <form method="POST" action="{{ route('carrito.reducir', $producto->id) }}">
                                                @csrf
                                                <button class="btn btn-outline-secondary btn-sm px-2">−</button>
                                            </form>
                                            <span class="fw-bold small px-1">{{ $cantidadEnCarrito }}</span>
                                        @endif
                                        @if($cantidadEnCarrito < $producto->stock)
                                            <form method="POST" action="{{ route('carrito.agregar', $producto->id) }}">
                                                @csrf
                                                <button class="btn btn-dark btn-sm px-2">+</button>
                                            </form>
                                        @else
                                            <span class="text-danger small">Máx.</span>
                                        @endif
                                    </div>
                                @endif
                            @endguest
                        @else
                            <span class="text-muted small">Sin stock</span>
                        @endif

                        @auth
                            @if(Auth::user()->email === env('ADMIN_EMAIL'))
                                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form method="POST" action="{{ route('productos.destroy', $producto->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                                </form>
                            @endif
                        @endauth
                     <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-info btn-sm">Ver más</a>

                    </div> 

                </div> 
            </div> 
            @endforeach
        </div> 
    @endif
</div>

<a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm ms-3 mb-3">← Inicio</a>

</body>
</html>