<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name'  => [
                'required', 'min:5', 'max:255',
                Rule::unique('users', 'name')->ignore($this->user->id)
            ],
            'email' => [
                'required', 
                Rule::unique('users', 'email')->ignore($this->user->id)
            ]
        ];
    }
}
