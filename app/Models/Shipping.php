<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ["order_id", "address", "country", "province", "city", "postal_code", "phone_number"];

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
