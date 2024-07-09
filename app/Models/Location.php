<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'active_flag',
        'location_group_id',
        'description',
        'name',
        'parent_id',
        'pickable',
        'receivable',
    ];
}
