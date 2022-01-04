<?php

namespace App\Http\Requests\Masters\InventoryStocks;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryStockRequest extends FormRequest
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
            'name' => 'required|string',
            'minimalQuantity' => 'nullable|integer|min:0',
            'price' => 'required',
            'category' => 'required|uuid',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'min' => 'Minimal 0 atau lebih besar.',
            'required' => 'Kolom ini diperlukan.',
        ];
    }
}
