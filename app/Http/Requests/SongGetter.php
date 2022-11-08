<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SongGetter extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            //
            "id" => "required",
            "category" => "numeric|min:0",
            "version" => "numeric|min:0",
            "keywords" => ""
        ];
    }
    public function messages() {
        return [
            "id.required" => "idは必ず入力してください",
        ];
    }
}
