<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        switch ($this->method()){

            case  'POST':{
                return [
                    'name' => 'required|max:50',
                    'email' => 'required|unique:users|max:255',
                    'password' => 'required|confirmed|min:6'
                ];
            }

            case 'PATCH':
            default:{
            return [
                'name' => 'required|max:50',
                'password' => 'nullable|confirmed|min:6'
            ];
            }
        }


    }
}
