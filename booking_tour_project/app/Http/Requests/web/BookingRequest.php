<?php

namespace App\Http\Requests\web;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'adult' => 'required|numeric|min:1',
            'child' => 'required|numeric|min:0',
            'date_start' => 'required'
        ];
    }
}
