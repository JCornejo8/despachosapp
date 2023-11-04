<?php

namespace App\Models;

use App\Http\Resources\DispatchDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispatch extends Model
{
    use HasFactory;
    protected $fillable = ['bill_number_disp', 'driver_name_disp', 'truck_plate_disp', 'date_disp'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    public function dispatchDetails()
    {
        return $this->hasMany(DispatchDetail::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id'); // Si tienes una columna client_id en tu tabla de despachos
    }
}
