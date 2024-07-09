<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'active_flag',
        'code',
        'last_changed_user_id',
        'name',
        'rate',
        'symbol'
    ];
}
