<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'activeFlag',
        'name',
        'number',
        'taxExempt',
        'toBeEmailed',
        'toBePrinted',
        'url',
        'payment_terms_id',
        'customer_status_id',
    ];
}
