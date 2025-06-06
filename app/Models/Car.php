<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Car extends Model
{
    use HasFactory;
    protected $fillable = [
        'brand',
        'model',
        'year',
        'color',
        'license_plate',
        'no_chassis',
        'no_engine',
        'price',
        'status',
        'description'
    ];
    public function sales()
    {
        return $this->hasOne(Sales::class ,'car_id');
    }
}
