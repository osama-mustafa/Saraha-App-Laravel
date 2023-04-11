<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'      => ['required', 'max:255', 'unique:users,name'],
            'email'     => ['required', 'unique:users,email'],
            'image'     => ['required', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
            'password'  => ['required']
        ];
    }
}
