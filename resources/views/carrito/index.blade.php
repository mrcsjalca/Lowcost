    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Carrito - Lowcost</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">

    <nav class="navbar navbar-light bg-white border-bottom px-4">
        <a href="/">
            <img src="https://i.pinimg.com/736x/54/36/68/543668b027f5e8456104c6088137f7b1.jpg" height="45" style="border-radius:8px;">
        </a>
        <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary btn-sm">← Volver</a>
    </nav>

    <div class="container py-5" style="max-width:700px;">

        <h1 class="fw-bold mb-4 text-center">Tu carrito</h1>
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(empty($carrito))
            <div class="text-center py-5">
                <img src="https://i.pinimg.com/736x/f7/b5/ec/f7b5ec35624a1bcb2973767c5a9b9305.jpg" class="mx-auto mb-2" style="width:80px;height:80px;object-fit:cover;border-radius:12px;">
                <p class="text-muted">Tu carrito está vacío.</p>
                <a href="{{ route('productos.index') }}" class="btn btn-dark">Ver productos</a>
            </div>
        @else
            <div class="card shadow-sm">
                <ul class="list-group list-group-flush">
                    @foreach($carrito as $id => $item)
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <img src="{{ asset($item['imagen'] ?? 'https://i.pinimg.com/736x/44/67/e7/4467e7b78bad687c95c5a4456160ec84.jpg') }}" style="width:50px;height:50px;object-fit:cover;border-radius:8px;" alt="{{ $item['nombre'] }}">
                        <div class="flex-grow-1">
                            <p class="mb-0 fw-semibold">{{ $item['nombre'] }}</p>
                            <p class="mb-0 text-muted small">{{ $item['cantidad'] }} x {{ number_format($item['precio'], 2) }} €</p>
                        </div>
                        <p class="mb-0 fw-bold text-success">{{ number_format($item['precio'] * $item['cantidad'], 2) }} €</p>
                        <form method="POST" action="{{ route('carrito.eliminar', (int)$id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">✕</button>
                        </form>
                    </li>
                    @endforeach
                    <li class="list-group-item d-flex align-items-center gap-3">
    <img src="{{ asset($item['imagen'] ?? 'images/default.jpg') }}" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
    <div class="flex-grow-1">
        <p class="mb-0 fw-semibold">{{ $item['nombre'] }}</p>
        <p class="mb-0 text-muted small">{{ number_format($item['precio'], 2) }} € / ud.</p>
    </div>

    {{-- Contador --}}
    <div class="d-flex align-items-center gap-1">
        <form method="POST" action="{{ route('carrito.reducir', (int)$id) }}">
            @csrf
            <button class="btn btn-outline-secondary btn-sm px-2">−</button>
        </form>
        <span class="fw-bold px-2">{{ $item['cantidad'] }}</span>
        <form method="POST" action="{{ route('carrito.agregar', (int)$id) }}">
            @csrf
            <button class="btn btn-dark btn-sm px-2">+</button>
        </form>
    </div>

    <p class="mb-0 fw-bold text-success">{{ number_format($item['precio'] * $item['cantidad'], 2) }} €</p>

    <form method="POST" action="{{ route('carrito.eliminar', (int)$id) }}">
        @csrf
        @method('DELETE')
        <button class="btn btn-outline-danger btn-sm">✕</button>
    </form>
</li>
                </ul>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <span class="fw-bold fs-5">Total: {{ number_format($total, 2) }} €</span>
                    <div class="d-flex gap-2">
                        <form method="POST" action="{{ route('carrito.vaciar') }}">
                            @csrf
                            <button class="btn btn-outline-secondary btn-sm">Vaciar carrito</button>
                        </form>
                        <form method="POST" action="{{ route('carrito.finalizar') }}">
                            @csrf
                            <button class="btn btn-dark btn-sm">Finalizar compra ✓</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>






    </body>
    </html>