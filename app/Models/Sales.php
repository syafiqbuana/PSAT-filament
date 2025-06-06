<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $fillable = [
        'car_id',
        'user_id',
        'customer_id',
        'sale_price',
        'sale_date',
        'price',
        'payment_method',
        'payment_status'
    ];
    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
