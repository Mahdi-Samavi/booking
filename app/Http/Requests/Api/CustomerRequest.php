<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'device_name' => ['required', 'string'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:customers,email'],
            'password' => ['required', 'string', 'confirmed'],
            'birthday' => ['required', 'date'],
            'phone' => ['required', 'string'],
            'country' => ['required', 'string'],
            'state' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
            'zipcode' => ['required', 'string'],
        ];
    }
}
