<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchDetail extends Model
{
    use HasFactory;
    protected $table = 'dispatch_details'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'dispatch_id', // ID del despacho al que pertenece este detalle
        'product_id', // ID del producto relacionado
        'quantity',   // Cantidad de productos despachados
    ];

    public function dispatch()
    {
        return $this->belongsTo(Dispatch::class, 'dispatch_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
