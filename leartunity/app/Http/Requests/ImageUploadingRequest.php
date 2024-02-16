<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ImageUploadingRequest extends FormRequest
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
            //
        ];
    }
    public function withValidator($validator) {
        $FileRule = [
            "required",
            File::types(["jpg", "jpeg", "png"])->max(2048)
        ];

        $validator->sometimes("profile_pic", $FileRule, function() {
            return request()->file("profile_pic");
        });

        $validator->sometimes("cover", $FileRule, function() {
            return request()->file("cover");
        });
    }
}
