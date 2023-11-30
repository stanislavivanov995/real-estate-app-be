<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
{
    /* TODO: Change to false when user auth */
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'images' => 'required',
            // 'images.*' => 'mimes:png,jpg,jpeg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'images.required' => 'At least one image is required',
            // 'images.*.mimes' => 'Available file formats are png, jpg, jpeg',
            'images.*.max' => 'Maximum file size is 2MB',
        ];
    }
}
