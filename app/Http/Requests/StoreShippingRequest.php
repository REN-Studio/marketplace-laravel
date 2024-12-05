<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShippingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "order_id"=>[
                'required',
                'integer',
                'exists:orders,id'
            ],
            "address"=>[
                'required',
                'string',
                'max:255'
            ],
            "country"=>[
                'required',
                'string',
                'max:255'
            ],
            "province"=>[
                'required',
                'string',
                'max:255'
            ],
            "city"=>[
                'required',
                'string',
                'max:255'
            ],
            "postal_code"=>[
                'required',
                'string',
                'max:255'
            ],
            "phone_number"=>[
                'nullable',
                'string',
                'max:10'
            ]
        ];
    }
}
