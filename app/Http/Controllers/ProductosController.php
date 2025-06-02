<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;

class ProductosController extends Controller
{
    public function index()
    {
        return view('productos.index');
    }
    public function create()
    {
        return view('productos.create');
    }
    public function store(Request $request)
    {
        dd($request->name);
        echo 'Producto creado exitosamente.';
    }
    public function show($id)
    {
        // Aquí puedes manejar la lógica para mostrar un producto específico
        return view('productos.show', compact('id'));
    }
    public function edit($id)
    {
        // Aquí puedes manejar la lógica para editar un producto específico
        return view('productos.edit', compact('id'));
    }
    public function update(Request $request, $id)
    {
        // Aquí puedes manejar la lógica para actualizar el producto
        // Por ejemplo, actualizar en la base de datos

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }
    public function destroy($id)
    {
        // Aquí puedes manejar la lógica para eliminar un producto específico
        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }

    public function confirmarCodigo(Request $request)
    {
        $codigo = $request->codigo;
        $codigo = Productos::where('codigo', $codigo)->first();

        if($codigo) {
            return response()->json(['success' => true, 'codigo' => $codigo]);
        } else {
            return response()->json(['success' => false, 'message' => 'Código no encontrado']);
        }

        return response()->json(['success' => true]);
    }
}

