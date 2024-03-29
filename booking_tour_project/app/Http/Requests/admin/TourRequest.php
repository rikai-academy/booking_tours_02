<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class TourRequest extends FormRequest
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
            'name' => 'required',
            'avata' => 'required',
            'description' => 'required',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'priceAdult' => 'required|numeric',
            'priceChild' => 'required|numeric',
            'image.*' => 'required',
            'title.*' => 'required',
            'program.*' => 'required'
        ];
    }
}
