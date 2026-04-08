<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de saldo - Lowcost</title>
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
    <h2 class="fw-bold mb-4">Gestión de saldo</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($usuarios->isEmpty())
        <p class="text-muted">No hay usuarios registrados.</p>
    @else
        <div class="card shadow-sm">
            <ul class="list-group list-group-flush">
                @foreach($usuarios as $usuario)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-0 fw-semibold">{{ $usuario->name }}</p>
                        <p class="mb-0 text-muted small">{{ $usuario->email }}</p>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="fw-bold text-success">{{ number_format($usuario->saldo, 2) }} €</span>
                        <form method="POST" action="{{ route('saldo.asignar', $usuario->id) }}" class="d-flex gap-2">
                            @csrf
                            <input type="number" name="saldo" step="0.01" min="0"
                                   value="{{ $usuario->saldo }}"
                                   class="form-control form-control-sm" style="width:100px;">
                            <button class="btn btn-dark btn-sm">Asignar</button>
                        </form>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

</body>
</html>