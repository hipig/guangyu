<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\FormRequest;

class EvaluateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'content' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'content' => '估价内容'
        ];
    }
}
