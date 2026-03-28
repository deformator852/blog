<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:60'],
            'content' => ['sometimes', 'string'],
            'category_id' => ['sometimes', 'exists:categories,id'],
            'image_path' => ['nullable', 'image', 'mimes:jpg,png,webp', 'max:10240'],
            'is_published' => ['sometimes', 'boolean'],
        ];
    }
}
