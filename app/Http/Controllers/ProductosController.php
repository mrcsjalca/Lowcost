<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $producto = new Producto();
        $title = "Crear nuevo producto";
        $textButton = "Crear";
        $route = route('productos.store');
        return view('productos.form', compact('producto', 'title', 'textButton', 'route'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required',
            'precio'      => 'required|numeric|min:0',
            'descripcion' => 'required',
            'categoria'   => 'required',
            'stock'       => 'required|integer|min:0',
            'imagen'      => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $producto = new Producto();
        $producto->nombre      = $request->nombre;
        $producto->precio      = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->categoria   = $request->categoria;
        $producto->stock       = $request->stock;

        if ($request->hasFile('imagen')) {
            $imageName = time() . '.' . $request->imagen->extension();
            $request->imagen->move(public_path('images'), $imageName);
            $producto->imagen = 'images/' . $imageName;
        }

        $producto->save();
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function show(string $id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);
        $title = "Editar producto";
        $textButton = "Actualizar";
         $route = route('productos.update.post', $producto->id);

        return view('productos.form', compact('producto', 'title', 'textButton', 'route'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre'      => 'required',
            'precio'      => 'required|numeric|min:0',
            'descripcion' => 'required',
            'categoria'   => 'required',
            'stock'       => 'required|integer|min:0',
            'imagen'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->nombre      = $request->nombre;
        $producto->precio      = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->categoria   = $request->categoria;
        $producto->stock       = $request->stock;

        if ($request->hasFile('imagen')) {
            if ($producto->imagen && file_exists(public_path($producto->imagen))) {
                unlink(public_path($producto->imagen));
            }
            $imageName = time() . '.' . $request->imagen->extension();
            $request->imagen->move(public_path('images'), $imageName);
            $producto->imagen = 'images/' . $imageName;
        }

        $producto->save();
        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $producto = Producto::findOrFail($id);
        if ($producto->imagen && file_exists(public_path($producto->imagen))) {
            unlink(public_path($producto->imagen));
        }
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}