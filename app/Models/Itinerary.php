<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Itinerary extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'day_number',
        'title',
        'description',
        'start_time',
        'end_time',
        'location',
    ];

    public function package()
    {
        return $this->belongsTo(TourPackage::class, 'package_id');
    }
}
