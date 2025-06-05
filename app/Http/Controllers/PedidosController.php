<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Productos;

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

    public function generarQR(Request $request)
    {
        date_default_timezone_set('America/Santiago');
        $id = $request->id;
    $bultos = $request->cantidad_bultos;
    $cliente = $request->cliente;
    $notaVenta = $request->nota_venta;

    $pedido = Pedidos::findOrFail($id);

    $pedidoIdBase = 'PED-' . now()->format('YmdHis') . rand(100, 999) . '-' . $pedido->id;

    $etiquetas = [];

    for ($i = 1; $i <= $bultos; $i++) {
        $codigoQR = $pedidoIdBase;

        $qrBase64 = base64_encode(
            QrCode::format('png')->size(200)->generate($codigoQR)
        );

        $etiquetas[] = [
            'qr' => $qrBase64,
            'texto' => "Pedido: $pedidoIdBase\nBulto: $i de $bultos",
            'pedido' => $pedido,
            'fecha_hora' => now()->format('d/m/Y H:i:s'),
            'nota_venta' => $notaVenta,
            'cliente' => $cliente,
        ];
    }

    $pdf = Pdf::loadView('codigo-qr', [
        'etiquetas' => $etiquetas
    ]);
    // Tamaño 100mm x 50mm
    $pdf->setPaper([0, 0, 283, 142]);
    $pedido->codigo_qr = $qrBase64;
    $pedido->estado_qr = '1';
    $pedido->estado = 'para_despacho';
    $pedido->cantidad_bultos = $bultos;
    $pedido->updated_at = now();
    $pedido->save();
    
    return $pdf->stream("etiquetas_pedido_{$pedido->id}.pdf");
    }

    public function verQr($id)
    {
        $pedido = Pedidos::findOrFail($id);
       // dd($pedido);

        for ($i=1; $i <= $pedido->cantidad_bultos; $i++) {
            $pedidoIdBase = 'PED-' . $pedido->updated_at->format('YmdHis') . rand(100, 999) . '-' . $pedido->id;
            $codigoQR = $pedidoIdBase;

            $etiquetas[] = [
                'qr' => $pedido->codigo_qr,
                'texto' => "Pedido: $pedidoIdBase\nBulto: $i de {$pedido->cantidad_bultos}",
                'pedido' => $pedido,
                'fecha_hora' => $pedido->updated_at->format('d/m/Y H:i:s'),
                'nota_venta' => $pedido->nota_venta,
                'cliente' => $pedido->cliente,
            ];
        }
        $pdf = Pdf::loadView('ver-qr', [
            'etiquetas' => $etiquetas
        ]);
// Tamaño 100mm x 50mm
    $pdf->setPaper([0, 0, 283, 142]);

        return $pdf->stream("etiquetas_pedido_{$pedido->id}.pdf");
    }



}
