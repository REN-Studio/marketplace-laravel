<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShippingRequest;
use App\Models\Order;
use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function store(StoreShippingRequest $request){
        $order = Order::find($request->validated("order_id"));

        if($order->shipping){
            return response()->json(['message' => "order sudah memiliki shipping address"], 422);
        }

        $shipping = Shipping::create($request->validated());
        return response()->json([
            'data' => $shipping
        ], 201);
    }
}
