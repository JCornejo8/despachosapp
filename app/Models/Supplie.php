<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplie extends Model
{
    use HasFactory;
    protected $fillable = ['code_sup', 'name_sup', 'stock_sup'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
}
