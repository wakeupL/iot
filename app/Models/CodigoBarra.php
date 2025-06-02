<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CodigoBarra extends Model
{
    use HasFactory;
    protected $table = 'codigo_barra';
    protected $fillable = [
        'producto_id',
        'codigo_barra',
        'tipo',
    ];
    protected $casts = [
        'producto_id' => 'integer',
    ];
    public function producto()
    {
        return $this->belongsTo(Productos::class);
    }
}
