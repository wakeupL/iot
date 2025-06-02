<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Productos;

class Pedidos extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'nota_venta',
        'responsable',
        'estado',
        'fecha_separacion',
        'fecha_entrega',
        'cliente',
        'codigo_qr',
        'estado_qr',
    ];

    // Define any relationships if necessary
    public function productos()
    {
        return $this->belongsToMany(Productos::class, 'pedido_producto');
    }
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }
    public function scopeEnProceso($query)
    {
        return $query->where('estado', 'en_proceso');
    }
    public function scopeCompletados($query)
    {
        return $query->where('estado', 'completado');
    }
    public function scopeResponsable($query, $nombre)
    {
        return $query->where('responsable', 'like', '%' . $nombre . '%');
    }
    public function scopeFechaEntrega($query, $fecha)
    {
        return $query->whereDate('fecha_entrega', $fecha);
    }
    public function scopeEntreFechasEntrega($query, $desde, $hasta)
    {
        return $query->whereBetween('fecha_entrega', [$desde, $hasta]);
    }
    public function scopeConProducto($query, $productoId)
    {
        return $query->whereHas('productos', function ($q) use ($productoId) {
            $q->where('productos.id', $productoId);
        });
    }

}
