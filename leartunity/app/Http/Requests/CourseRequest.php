<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Validator;

class CourseRequest extends FormRequest
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
        $rules = [
            "title" => ["required"],
            "description" => ["required"],
            "pre_req" => ["required"],
            "price" => ["required", "integer"],
            "categories" => [ "required" ],
        ];
        if(!request()->routeIs("course.update")) {
            $rules["image"] = ["required"];
        }
        return $rules;
    }

    public function after() {
        return [
            function(Validator $validator) {
                $withoutContinuosSpace = [
                    preg_replace('/\s+/', ' ', $this->description),
                    preg_replace('/\s+/', ' ', $this->pre_req)
                ];

                $description = explode(" ", $withoutContinuosSpace[0]);
                $pre_req = explode(" ", $withoutContinuosSpace[1]);
                if(count($description) < 25) {
                    $validator->errors()->add(
                        'description',
                        "Minimum 25 words are required"
                    );
                }
                if(count($pre_req) < 25) {
                    $validator->errors()->add(
                        'pre_req',
                        "Minimum 25 words are required"
                    );
                }
            }
        ];
    }
}
