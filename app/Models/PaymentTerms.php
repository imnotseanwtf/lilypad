<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTerms extends Model
{
    use HasFactory;

    protected $table = 'paymentterms';

    protected $fillable = [
        'accountingHash',
        'accountingId',
        'activeFlag',
        'dateCreated',
        'dateLastModified',
        'defaultTerm',
        'discount',
        'discountDays',
        'name',
        'netDays',
        'nextMonth',
        'readOnly',
        'typeId',
    ];

    public $timestamps = false;
}
