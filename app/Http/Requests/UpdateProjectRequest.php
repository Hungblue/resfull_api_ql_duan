<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class UpdateProjectRequest extends BaseRequest
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
            'name' => 'unique:projects',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Dự án đã tồn tại'
        ];
    }
}
