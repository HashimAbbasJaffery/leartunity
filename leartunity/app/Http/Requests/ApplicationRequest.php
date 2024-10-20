<?php

namespace App\Http\Requests;

use App\Rules\lteConstant;
use App\Rules\WordLength;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            "fullname" => ["required", "max:50"],
            "qualification" => ["required", Rule::in(["0", "1", "2", "3", "4"])],
            "cover_letter" => ["required", new WordLength(3, 1000)],
            "supporting_file" => ["nullable", "extensions:pdf,doc,docx", "max:2048"],
            "read_conditions" => ["in:1"]
        ];
    }
    public function messages() {
        return [
            "fullname.required" => "You must provide your full name",
            'supporting_file.extensions' => 'File must be PDF',
            'read_conditions.in' => "You must accept the terms and conditions"
        ];
    }
}
