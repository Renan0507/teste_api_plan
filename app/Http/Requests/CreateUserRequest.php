<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'      =>  ['required', 'min:2', 'string'],
            'email'     =>  ['required', 'email', 'unique:users'],
            'password'  =>  ['required', 'min:3'],
            'phone'     =>  ['nullable', 'digits:11'],
            'image'     =>  ['required', 'file', 'mimes:png,jpg,jpeg']
        ];
    }
}
