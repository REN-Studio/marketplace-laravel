<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $itemsData = [];
        foreach ($this->items as $item){
            $itemsData[] = [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'total_price' => $item->total_price
            ];
        }

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'total_price' => $this->total_price,
            'items' => $itemsData
        ];
    }
}
