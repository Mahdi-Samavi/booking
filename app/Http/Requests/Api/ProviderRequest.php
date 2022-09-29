<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProviderRequest extends FormRequest
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
        $isUnique = in_array('POST', request()->route()->methods()) ? 'unique:providers,email' : '';

        return [
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'avatar' => ['required', 'image'],
            'email' => ['required', 'email', $isUnique],
            'phone' => ['required', 'numeric'],
            'biography' => ['required', 'string'],
            'holiday_work' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
        ];
    }
}
