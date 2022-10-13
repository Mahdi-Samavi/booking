<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'category' => ['required', 'array'],
            'category.*' => ['exists:categories,id'],
            'title' => ['required'],
            'amount' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'cover' => ['required', 'image'],
            'gallery' => ['required'],
            'gallery.*' => ['image'],
            'duration' => ['required', 'numeric'],
            'presence_type' => ['required', 'in:in-person,zoom,"google meet"'],
            'capacity' => ['required', 'numeric'],
            'cancel_at' => ['required', 'numeric'],
            'status' => ['required', 'boolean'],
        ];
    }
}
