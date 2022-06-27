<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckPointRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_assess' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name_assess.required' => 'Tên kỳ đánh giá không được để trống',
            'start_date.required' => 'Thời gian không được để trống',
            'end_date.required' => 'Thời gian không được để trống',
        ];
    }
}
