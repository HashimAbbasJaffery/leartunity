<?php

namespace App\Http\Requests;

use App\Rules\lteConstant;
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
    protected function lteConstant($constant) {
        return Rule::custom(function($attribute, $value, $parameters) use ($constant) {
            return $value <= $constant;
        });
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
            "email" => ["required", "email"],
            "age" => ["required", "numeric", new lteConstant],
            "qualification" => ["required", Rule::in(["matriculation", "intermediate", "undergraduate", "graduate", "post-graduate"])],
            "niche" => ["required", Rule::in(["data-science", "web-development", "python"])],
            "cover_letter" => ["required", "min:255", "max:1000"],
            "supporting-file" => ["nullable", "extensions:pdf,rar,zip"],
            "t&c" => ["required"]
        ];
    }
    public function messages() {
        return [
            't&c.required' => "You must accept the terms and conditions"
        ];
    }
}
