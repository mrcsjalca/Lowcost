<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra completada - Lowcost</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-light bg-white border-bottom px-4">
    <a href="/">
        <img src="https://i.pinimg.com/736x/54/36/68/543668b027f5e8456104c6088137f7b1.jpg" height="45" style="border-radius:8px;">
    </a>
</nav>

<div class="container py-5 text-center" style="max-width:600px;">

    <img src="{{ asset($item['imagen'] ?? 'https://i.pinimg.com/736x/e3/e5/d2/e3e5d2a2423e4be1bc94f1690e24750d.jpg') }}" style="width:150px;height:150px;object-fit:cover;border-radius:8px;">                    
    <h2 class="fw-bold mb-2">¡Compra realizada con exito!</h2>
    <p class="text-muted mb-4">El dinero me ha llegado perfecto. Aquí tienes el resumen:</p>

    @if(!empty($resumen))
    <div class="card shadow-sm mb-4">
        <ul class="list-group list-group-flush">
            @foreach($resumen as $item)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ asset($item['imagen'] ?? 'https://i.pinimg.com/736x/44/67/e7/4467e7b78bad687c95c5a4456160ec84.jpg') }}" style="width:50px;height:50px;object-fit:cover;border-radius:8px;">                    
                    <span>{{ $item['nombre'] }} <span class="text-muted small">x{{ $item['cantidad'] }}</span></span>
                </div>
                <span class="fw-bold text-success">{{ number_format($item['precio'] * $item['cantidad'], 2) }} €</span>
            </li>
            @endforeach
        </ul>
        <div class="card-footer text-end fw-bold fs-5">
            Total: {{ number_format($total, 2) }} €
        </div>
    </div>
    @endif

    <a href="{{ route('productos.index') }}" class="btn btn-dark px-4">Seguir comprando</a>
</div>

</body>
</html>