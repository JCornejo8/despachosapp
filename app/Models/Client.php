<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name_cli', 'code_cli'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    use HasFactory;
    public function dispatches()
    {
        return $this->hasMany(Dispatch::class);
    }
    
}
