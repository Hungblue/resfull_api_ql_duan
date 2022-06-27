<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AchievementWorkRequest extends BaseRequest
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
            'check_point_id' => 'required',
            'project_id' => 'required',
            'participation_time' => 'required',
            'work_name' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'check_point_id'=> 'Tên kỳ đánh giá không được để trống',
            'project_id.required' => 'Tên dự án không được để trống',
            'participation_time.required' => 'Thời gian tham gia không được để trống',
            'work_name.required' => 'Công việc được giao không được để trống',
        ];
    }
}
