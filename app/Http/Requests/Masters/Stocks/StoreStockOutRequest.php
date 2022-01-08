<?php

namespace App\Http\Requests\Masters\Stocks;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockOutRequest extends FormRequest
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
            'stockType' => 'required',
            'date' => 'required',
            'notes' => 'nullable',
            'inventoryStock' => 'required|array',
            'quantity' => 'required|array',
            'notesDetail' => 'nullable|array'
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
