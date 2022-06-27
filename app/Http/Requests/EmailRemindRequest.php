<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EmailRemindRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required', Rule::unique('email_remind')->ignore($this->id)
            ],


        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được để trống',
            'email.unique' => 'email đã tồn tại'
        ];
    }
}
