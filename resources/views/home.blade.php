@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">Lista de Productos</h1>

    @if(Auth::check() && Auth::user()->email === env('ADMIN_EMAIL'))

    <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">
        + Nuevo Producto
    </a>

    @endif
    
    @if(Auth::check() && Auth::user()->email === env('ADMIN_EMAIL'))
    <a href="{{ route('saldo.index') }}" class="btn btn-warning btn-sm">Saldos</a>
    @endif
    
    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Precio (€)</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($productos as $producto)
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->precio }}</td>
                            <td>{{ $producto->categoria }}</td>
                            <td>{{ $producto->stock }}</td>

                            <td>
                                @if($producto->imagen)
                                <img src="{{ asset($producto->imagen) }}" width="80">
                                @else
                                    Sin imagen
                                @endif
                            </td>

                            <td>

                                <a href="{{ route('productos.show', $producto) }}" class="btn btn-info btn-sm">
                                    Ver
                                </a>


                                @if(Auth::check() && Auth::user()->email === env('ADMIN_EMAIL'))
                                <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning btn-sm">
                                    Editar
                                </a>

                                <form action="{{ route('productos.destroy', $producto) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro?')">
                                        Eliminar
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay productos</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection