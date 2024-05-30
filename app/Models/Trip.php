<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    public function fromGovernorate()
    {
        return $this->belongsTo(Governorate::class, 'from_governorate');
    }

    public function toGovernorate()
    {
        return $this->belongsTo(Governorate::class, 'to_governorate');
    }
    public function reservations()
{
    return $this->hasMany(Reservation::class);
}

}