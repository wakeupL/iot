<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productos extends Model
{
    use Hasfactory;
    protected $table = 'productos';
    protected $fillable = [
        'nombre',
        'codigo_barra',
        'descripcion',
        'unidades_por_embalaje',
        'stock_total',
        'stock_reservado',
    ];
    protected $casts = [
        'unidades_por_embalaje' => 'integer',
        'stock_total' => 'integer',
        'stock_reservado' => 'integer',
    ];
    public function codigos()
    {
        return $this->hasMany(CodigoBarra::class);
    }
}
