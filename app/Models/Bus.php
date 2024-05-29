<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bus extends Model
{
    use HasFactory ,SoftDeletes;
    protected $fillable = [
        'bus_number',
        'registration_number',
        'make',
        'model',
        'year_of_manufacture',
        'capacity',
        'status',
        'driver_id',
    ];
}