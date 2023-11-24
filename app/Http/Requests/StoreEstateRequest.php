<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreEstateRequest extends FormRequest
{
    /*
    TODO: false when auth users
     */
    public function authorize(): bool
    {
        return true;
    }
    

    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'name' => 'required',
            'location' => 'required',
            'price' => 'required|integer|min:0',
            'currency' => 'required',
            'category_id' => 'required',
            'rooms' => 'required|integer|min:1',
            'arrive_hour' => 'required',
            'leave_hour' => 'required',
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
    
    /*
    TODO: Sinchronise messages with Front-end validation
    */ 
    public function messages()
    {
        return [
            'user_id.required' => 'User id field is required',
            'name.required' => 'Title field is required',
            'location.required' => 'Location is required',
            'price.required' => 'Price is required',
            'price.min' => 'Price must be positive',
            'currency.required' => 'Currency is required',
            'category_id.required' => 'Category is required',
            'rooms.required' => 'Rooms count is required',
            'rooms.min' => 'Rooms count must be at least one',
            'arrive_hour.required' => 'Arrive hour is required',
            'leave_hour.required' => 'Leave hour is required'
        ];
    }
}
