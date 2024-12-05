<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\ListOrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request){
        // dd($request->validated());
        try {
            $orderData = DB::transaction(function() use ($request){
                $order = Order::create($request->only(["user_id", "total_price"]));
                $runOutStock = false;
                foreach ($request->validated("items") as $key => $item) {
                    $product = Product::where("id", "=", $item["product_id"])->first();
                    if($product->stock < $item["quantity"]){
                        $runOutStock = true;
                        break;
                    } else {
                        // $product->stock -= $item["quantity"];        or
                        $product->stock = $product->stock - $item["quantity"];
                        $product->save();
                    }
    
                    // 1st way
                    // $order->items()->create($item);
                    // 2nd way
                    $orderItem = new OrderItem($item);
                    $orderItem->order_id = $order->id;
                    $orderItem->save();
                }
                if($runOutStock){
                    throw new Exception("Product stock is not enough");
                }
    
                $order->loadMissing("items");
    
                return $order;
            });
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                'stok' => [$th->getMessage()],
            ]);
        }

        return ListOrderResource::make($orderData);
    }

    public function index(){
        $orders = Order::with("items")->get();

        return ListOrderResource::collection($orders); //kumpulan dari banyak order
    }

    public function update(StoreOrderRequest $request, Order $order){
        $orderDataUpdate = DB::transaction(function() use ($request, $order){
            $order->update($request->only(["user_id", "total_price"]));

            foreach ($request->validated("items") as $key => $item){
                $orderItem = $order->items()->where("id", "=", $item["id"])->first();
                $orderItem->update([
                    "product_id" => $item["product_id"],
                    "price" => $item["price"],
                    "quantity" => $item["quantity"],
                    "total_price" => $item["total_price"]
                ]);
            }

            $order->loadMissing("items");

            return $order;
        });

        return ListOrderResource::make($orderDataUpdate);
    }

    public function destroy(Order $order){
        $order->items()->delete();
        $order->delete();
        return response()->json(["message" => "Order Berhasil Dihapus"]);
    }
}
