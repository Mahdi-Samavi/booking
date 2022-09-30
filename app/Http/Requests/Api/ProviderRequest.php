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
            'category' => ['required', 'array'],
            'category.*' => ['exists:categories,id'],
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'avatar' => ['required', 'image'],
            'email' => ['required', 'email', $isUnique],
            'password' => ['required', 'string'],
            'phone' => ['required', 'string', 'min:8'],
            'biography' => ['required', 'string'],
            'holiday_work' => ['required', 'boolean'],
            'activities' => ['required', 'array'],
            'status' => ['required', 'boolean'],
        ];
    }
}
