<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartCost extends Model
{
    use HasFactory;

    protected $table = 'partcost';

    protected $fillable =
    [
        'avgCost',
        'dateCreated',
        'dateLastModified',
        'partId',
        'qty',
        'totalCost',
    ];

    public $timestamps = false;
}
