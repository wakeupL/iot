<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    protected $table = 'kardex';

    protected $fillable = [
        'tipo_ingreso',
        'cantidad',
        'documento',
        'producto_id',
        'responsable',
        'fecha_ingreso',
    ];

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id');
    }
}
