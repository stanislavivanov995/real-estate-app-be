<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreEstateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /*
        TODO: false for production
        */
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /*
            TODO: unique fields?
            */
            'user_id' => 'required',
            'name' => 'required | string | min:2 | max:100',
            'description' => 'string',
            'rooms' => 'required | integer',
            'price' => 'required | integer',
            'currency' => 'required | string',
            'latitude' => 'string',
            'longtitude' => 'string',
            'category' => 'required | string | min:2 | max:100',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $result = array('Errors' => [
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]);
        throw new HttpResponseException(response()->json($result));
    }

    public function messages()
    {
        return [
            'user_id.required' => 'User id field is required',
            'name.required' => 'Title field is required',
            'name.min' => 'Title must contain minimum 2 characters',
            'name.max' => 'Title must contain maximum 100 characters',
            'category.required' => 'Category field is required',
            'category.min' => 'Category must contain minimum 2 characters',
            'category.max' => 'Category must contain maximum 100 characters',
            'rooms.required' => 'Rooms field is required',
            'price.required' => 'Price field is required',
        ];
    }
}
