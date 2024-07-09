<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qbClass extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'accounting_hash',
        'accounting_id',
        'active_flag',
        'name',
        'parent_id',
    ];
}
