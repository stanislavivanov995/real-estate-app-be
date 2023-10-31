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
            'title' => 'required | string | min:2 | max:100',
            'city' => 'required | string | min:2 | max:100',
            'address' => 'required | string | min:2 | max:200',
            'type' => 'required | string | min:2 | max:100',
            'rooms' => 'required | integer',
            'price' => 'required | decimal:0',
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
            'title.required' => 'Title field is required',
            'title.min' => 'Title must contain minimum 2 characters',
            'title.max' => 'Title must contain maximum 100 characters',
            'address.required' => 'Address field is required',
            'address.min' => 'Address must contain minimum 2 characters',
            'address.max' => 'Address must contain maximum 200 characters',
            'type.required' => 'Type field is required',
            'type.min' => 'Real estate type must contain minimum 2 characters',
            'type.max' => 'Real estate type must contain maximum 100 characters',
            'rooms.required' => 'Rooms field is required',
            'price.required' => 'Price field is required',
        ];
    }
}
