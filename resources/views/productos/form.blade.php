<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 600px;">

    <h1 class="mb-4">{{ $title }}</h1>

    <form method="POST" action="{{ $route }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input name="nombre" type="text" class="form-control" value="{{ old('nombre') ?? $producto->nombre }}">
            @error('nombre') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Precio (€)</label>
            <input name="precio" type="number" step="0.01" min="0" class="form-control" value="{{ old('precio') ?? $producto->precio }}">
            @error('precio') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion') ?? $producto->descripcion }}</textarea>
            @error('descripcion') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <input name="categoria" type="text" class="form-control" value="{{ old('categoria') ?? $producto->categoria }}">
            @error('categoria') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input name="stock" type="number" min="0" class="form-control" value="{{ old('stock') ?? $producto->stock }}">
            @error('stock') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen</label>
            <input name="imagen" type="file" class="form-control" accept="image/*">
            @isset($producto->imagen)
                <img src="{{ asset($producto->imagen) }}" class="mt-2 rounded" style="height:80px;">
            @endisset
            @error('imagen') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">{{ $textButton }}</button>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>

</div>
</body>
</html>