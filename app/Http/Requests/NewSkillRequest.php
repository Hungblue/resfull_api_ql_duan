<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewSkillRequest extends BaseRequest
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
            'name_skill' => 'required',
            'level_id' => 'required',
            'type_skill_id' => 'required',
            'check_point_id' =>'required'
        ];
    }
    public function messages()
    {
        return [
            'name_skill.required' => 'Tên kỹ năng không được để trống',
            'level_id.required' => 'Trình độ không được để trống',
            'type_skill_id.required' => 'Loại kỹ năng không được để trống',
            'check_point_id.required' => 'Tên kỳ đánh giá không được để trống',
        ];
    }
}
