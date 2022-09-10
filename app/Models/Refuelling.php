<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refuelling extends Model
{
    use HasFactory;

    protected $fillable = [
        'fleet_id',
        'machine_hours',
        'fuel_added',
        'location',
        'isTankFilled',
        'date'
    ];

    protected $casts = [
        'fuel_added' => 'float',
        'machine_hours' => 'float',
    ];

    protected function fuelAdded(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 2, '.', ''),
        );
    }

    protected function machineHours(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 1, '.', ''),
        );
    }

    function fleet() {
        return $this->belongsTo(Fleet::class);
    }
}
