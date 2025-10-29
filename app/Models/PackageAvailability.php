<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'date_start',
        'date_end',
        'available_slots',
        'price_override_minor',
        'min_pax',
        'max_pax'
    ];

    public function package()
    {
        return $this->belongsTo(TourPackage::class, 'package_id');
    }
}
