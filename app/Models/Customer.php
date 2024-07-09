<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'active_flag',
        'default_payment_terms_id',
        'name',
        'number',
        'status_id',
        'tax_exempt',
        'to_be_emailed',
        'to_be_printed',
        'url',
    ];
}
