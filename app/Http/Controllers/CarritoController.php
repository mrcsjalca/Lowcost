<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
       
    
    public function index()
    {
        $carrito = session()->get('carrito', []);
        $total = array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], $carrito));
        return view('carrito.index', compact('carrito', 'total'));
    }
    
public function agregar(Request $request, string $id)
{
    $producto = Producto::findOrFail($id);
    $carrito = session()->get('carrito', []);

    $cantidadActual = isset($carrito[$id]) ? $carrito[$id]['cantidad'] : 0;

    // No dejar añadir más de lo que hay en stock
    if ($cantidadActual >= $producto->stock) {
        return redirect()->route('productos.index')
            ->with('error', "No hay más stock disponible de \"{$producto->nombre}\".");
    }

    if (isset($carrito[$id])) {
        $carrito[$id]['cantidad']++;
    } else {
        $carrito[$id] = [
            'nombre'   => $producto->nombre,
            'precio'   => $producto->precio,
            'imagen'   => $producto->imagen,
            'cantidad' => 1,
        ];
    }

    session()->put('carrito', $carrito);
    return redirect()->back()->with('success', "\"{$producto->nombre}\" añadido al carrito.");
}

public function reducir(string $id)
{
    $carrito = session()->get('carrito', []);

    if (isset($carrito[$id])) {
        if ($carrito[$id]['cantidad'] > 1) {
            $carrito[$id]['cantidad']--;
        } else {
            unset($carrito[$id]);
        }
    }

    session()->put('carrito', $carrito);
    return redirect()->back();
}

public function finalizar()
{
    $carrito = session()->get('carrito', []);

    if (empty($carrito)) {
        return redirect()->route('carrito.index');
    }

    $total = array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], $carrito));
    $user = auth()->user();

    // Comprobar saldo suficiente
    if ($user->saldo < $total) {
        return redirect()->route('carrito.index')
            ->with('error', 'No tienes saldo suficiente para completar la compra.');
    }

    // Comprobar stock de cada producto
    foreach ($carrito as $id => $item) {
        $producto = Producto::find($id);
        if (!$producto || $producto->stock < $item['cantidad']) {
            return redirect()->route('carrito.index')
                ->with('error', "No hay suficiente stock de \"{$item['nombre']}\".");
        }
    }

    // Descontar saldo y stock
    foreach ($carrito as $id => $item) {
        $producto = Producto::find($id);
        $producto->stock -= $item['cantidad'];
        $producto->save();
    }

    $user->saldo -= $total;
    $user->save();

    session()->put('resumen_compra', $carrito);
    session()->forget('carrito');

    return redirect()->route('carrito.resumen');
}

public function resumen()
{
    $resumen = session()->get('resumen_compra', []);
    $total = array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], $resumen));
    return view('carrito.resumen', compact('resumen', 'total'));
} 

public function vaciar()
{
        session()->forget('carrito');
        return redirect()->route('carrito.index')->with('success', 'Carrito vaciado.');
}   

public function eliminar($id)
{
    $carrito = session()->get('carrito', []);

    if (isset($carrito[$id])) {
        unset($carrito[$id]);
    }

    session()->put('carrito', $carrito);

    return redirect()->route('carrito.index')->with('success', 'Producto eliminado.');
}


}
