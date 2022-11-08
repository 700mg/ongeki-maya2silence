<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminSongUpdateDetail extends FormRequest {
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
            "title" => "required",
            "level" => "numeric|nullable|min:0",
            "jacket" => "mimes:jpg"
        ];
    }
    public function messages() {
        return [
            //
            "title.required" => "タイトルは必ず入力してください",
            "level.min" => "レベルは正の整数で入力してください",
            "jacket.mimes" => "ジャケットは.jpgのみアップロードできます"
        ];
    }
}
