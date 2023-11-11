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
            'user_id' => 'required | integer',
            'name' => 'required | string | min:2 | max:100',
            'description' => 'string',
            'price' => 'required | numeric | min:0',
            'currency' => 'required | string',
            'latitude' => 'string',
            'longtitude' => 'string',
            'category' => 'required | numeric | min:1 | max:5',
            'rooms' => 'required | numeric | min:1',
            'arrive_hour' => 'required | string',
            'leave_hour' => 'required | string',
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
            'name.min' => 'Title must contain minimum 2 characters',
            'name.max' => 'Title must contain maximum 100 characters',
            'price.required' => 'Price field is required',
            'price.min:0' => 'Price cannot be negative',
            'currency.required' => 'Currency field is required',
            'category.required' => 'Category field is required',
            'category.min:1' => 'Category id must be between 1 and 5',
            'category.max:5' => 'Category id must be between 1 and 5',
            'rooms.required' => 'Rooms field is required',
            'rooms.min:1' => 'Rooms cannot be less than 1',
            'arrive_hour.required' => 'Arrive Hour field is required',
            'leave_hour.required' => 'Leave Hour field is required'
        ];
    }
}
