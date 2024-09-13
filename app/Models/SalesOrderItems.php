<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SalesOrderItems extends Model
{
    use HasFactory;

    protected $table = 'soitem';

    protected $fillable = [
        'adjustAmount', // nullable
        'adjustPercentage', // nullable
        'customerPartNum', // nullable
        'dateLastFulfillment', // nullable
        'dateLastModified', // nullable
        'dateScheduledFulfillment', // nullable
        'description', // nullable
        'exchangeSOLineItem', // nullable
        'itemAdjustId', // nullable
        'markupCost', // nullable
        'mcTotalPrice', // nullable
        'note',
        'productId', // nullable
        'productNum', // nullable
        'qbClassId', // nullable
        'qtyFulfilled', // nullable
        'qtyOrdered', // nullable
        'qtyPicked', // nullable
        'qtyToFulfill', // nullable
        'revLevel', // nullable
        'showItemFlag',
        'soId',
        'soLineItem',
        'statusId',
        'taxId', // nullable
        'taxRate', // nullable
        'taxableFlag',
        'totalCost', // nullable
        'totalPrice', // nullable
        'typeId',
        'unitPrice', // nullable
        'uomId', // nullable
    ];

    public $timestamps = false;

    public function salesOrder(): HasOne
    {
        return $this->hasOne(SalesOrder::class, 'id', 'soId');
    }
}
