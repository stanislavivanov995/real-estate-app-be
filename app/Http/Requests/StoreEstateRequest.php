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
            'price' => 'required',
            'currency' => 'required',
            'category' => 'required',
            'rooms' => 'required',
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
            'price.required' => 'Price field is required',
            'currency.required' => 'Currency field is required',
            'category.required' => 'Category field is required',
            'rooms.required' => 'Rooms field is required',
            'arrive_hour.required' => 'Arrive Hour field is required',
            'leave_hour.required' => 'Leave Hour field is required'
        ];
    }
}
