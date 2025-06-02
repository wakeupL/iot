<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use Illuminate\Http\Request;

class PedidosController extends Controller
{
    //

    public function registrarPedido(Request $request)
    {
        $notaVenta = $request->notaVenta;
        $cliente = $request->cliente;
        $responsable = $request->responsable;

        date_default_timezone_set('America/Santiago');

        $nuevaPreparacion = Pedidos::create([
            'nota_venta' => $notaVenta,
            'responsable' => $responsable,
            'codigo_qr'=> '',
            'estado_qr'=> '0',
            'estado' => 'en_proceso',
            'fecha_separacion' => now(),
            'cliente' => $cliente,
        ]);

        return redirect()->route('pedido.preparar', $nuevaPreparacion->id);
    }

    public function index()
    {
        return view('pedidos');
    }

    public function prepararPedido($id)
    {
        return view('preparar-pedido', compact('id'));
    }
}
