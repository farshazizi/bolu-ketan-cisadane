<?php

namespace App\Http\Requests\Transactions\Sales;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
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
            'notes' => 'nullable',
            'grandTotal' => 'required',
            'detail' => 'required|array',
            'detail.*.inventoryStock' => 'required|string',
            'detail.*.quantity' => 'required',
            'detail.*.price' => 'required',
            'detailAdditional' => 'sometimes|array'
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
            'date.required' => 'Tanggal wajib diisi.',
        ];
    }
}
