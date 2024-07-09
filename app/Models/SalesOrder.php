<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'customerName',
        'customerContact',
        'billToAddress',
        'billToCity',
        'billToName',
        'billToZip',
        'dateFirstShip',
        'shipToAddress',
        'shipToCity',
        'shipToName',
        'shipToZip',
        'tax_id',
        'country_id',
        'state_id',
        'account_type_id',
        'customer_id',
        'carrier_id',
        'carrier_service_id',
    ];
}
