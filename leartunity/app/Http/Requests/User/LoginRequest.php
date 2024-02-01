<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => [ "required", "email" ],
            "password" => [ "required" ]
        ];
    }
    public function attributes(): array {
        return [
            "email" => "email address"
        ];
    }
}
