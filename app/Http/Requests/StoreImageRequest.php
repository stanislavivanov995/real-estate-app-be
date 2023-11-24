<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }
    
    public function rules(): array
    {
        return [
            'images.*' => 'required|mimes:png,jpg,jpeg|max:2048',
        ];
    }
}
