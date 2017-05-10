<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyerRequest extends FormRequest
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
            'cpf' => 'required|unique:users|numeric',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'phone' => 'required|min:6',
            'birth' => 'required|date_format:Y-m-d',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'A :attribute is required',
        ];
    }
}
