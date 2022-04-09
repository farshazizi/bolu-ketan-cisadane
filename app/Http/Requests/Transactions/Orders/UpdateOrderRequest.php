<?php

namespace App\Http\Requests\Transactions\Orders;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required',
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'grandTotal' => 'required',
            'notes' => 'nullable|string',
            'status' => 'required|string',
            'detail' => 'required|array',
            'detail.*.inventoryStock' => 'required|string',
            'detail.*.quantity' => 'required',
            'detail.*.price' => 'required',
            'detailAdditional' => 'sometimes|array'
        ];
    }
}
