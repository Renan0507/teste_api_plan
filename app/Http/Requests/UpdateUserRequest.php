<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'      =>  ['required', 'min:2', 'string'],
            'email'     =>  ['required', 'email', Rule::unique('users')->ignore($this->route('id'))],
            'password'  =>  ['nullable', 'min:3'],
            'phone'     =>  ['nullable', 'min: 11'],
            'image'     =>  ['nullable']
        ];
    }
}
