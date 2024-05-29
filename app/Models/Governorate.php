<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Governorate extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];
    public function fromTrips()
    {
        return $this->hasMany(Trip::class, 'from_governorate');
    }

    public function toTrips()
    {
        return $this->hasMany(Trip::class, 'to_governorate');
    }
}