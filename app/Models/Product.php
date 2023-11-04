<?php

namespace App\Models;

use App\Http\Resources\DispatchDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['lot_prod', 'code_prod','name_prod', 'stock_prod'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    public function dispatchDetails()
    {
        return $this->hasMany(DispatchDetail::class);
    }
}
