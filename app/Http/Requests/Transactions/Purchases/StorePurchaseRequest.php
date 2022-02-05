<?php

namespace App\Http\Requests\Transactions\Purchases;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
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
            'detail.*.ingredient' => 'required|string',
            'detail.*.quantity' => 'required',
            'detail.*.price' => 'required'
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
