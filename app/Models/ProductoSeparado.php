<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoSeparado extends Model
{
    protected $table = 'producto_separado';

    protected $fillable = [
        'producto_id',
        'cantidad',
        'nota_venta_id',
        'responsable',
    ];

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id');
    }

    public function notaVenta()
    {
        return $this->belongsTo(Pedidos::class, 'nota_venta_id');
    }
}
