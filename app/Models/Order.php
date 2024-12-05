<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'total_price'];

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function shipping(){
        return $this->hasOne(Shipping::class);
    }
}
