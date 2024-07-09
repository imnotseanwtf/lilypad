<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrierService extends Model
{
    use HasFactory;

    protected $fillable = [
        'carrier_id',
        'active_flag',
        'code',
        'name',
        'read_only'
    ];
}
