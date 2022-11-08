<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminSongUpdateDifficult extends FormRequest {
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
            "*.notes" => "numeric|nullable|regex:/^[+]?\d+$/",
            "*.bells" => "numeric|nullable|regex:/^[+]?\d+$/",
            "*.noteA" => "numeric|nullable|regex:/^[+]?\d+$/",
            "*.noteB" => "numeric|nullable|regex:/^[+]?\d+$/",
            "*.const" => "numeric|nullable|regex:/^\d+(\.\d)?$/"
        ];
    }
    public function messages() {
        return [
            //
            "*.notes.regex" => "値は正の数で入力してください。",
            "*.bells.regex" => "値は正の数で入力してください。",
            "*.noteA.regex" => "値は正の数で入力してください。",
            "*.noteB.regex" => "値は正の数で入力してください。",
            "*.const.regex" => "定数が不正です",
        ];
    }
}
