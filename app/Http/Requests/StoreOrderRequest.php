<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "user_id"=>[
                'required',
                'integer',
                'exists:users,id'
            ],
            "total_price"=>[
                'required',
                'integer',
                'min:0'
            ],
            "items"=>[
                'required',
                'array',
                'min:1'
            ],
            "items.*.id"=>[
                'nullable',
                'integer',
                'exists:order_items,id'
            ],
            "items.*.product_id"=>[
                'required',
                'integer',
                'exists:products,id'
            ],
            "items.*.quantity"=>[
                'required',
                'integer',
                'min:1'
            ],
            "items.*.price"=>[
                'required',
                'integer',
                'min:0'
            ],
            "items.*.total_price"=>[
                'required',
                'integer',
                'min:0'
            ]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            "items.*.id"=>"order item id",
            "items.*.total_price"=>"total price",
            "items.*.price"=>"price",
            "items.*.quantity"=>"quantity",
            "items.*.product_id"=>"product"
        ];
    }
}
