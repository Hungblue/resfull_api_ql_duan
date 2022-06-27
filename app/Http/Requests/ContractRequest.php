<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends BaseRequest
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
            'user_id' => 'required',
            'type_contract' => 'required',
            // 'type_allowance' => 'required',
            'position' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Tên nhân viên không được để trống',
            'type_contract.required' => 'Loại hợp đồng không được để trống',
            // 'type_allowance.required' => 'Loại trợ cấp không được để trống',
            'position.required' => 'Vị trí không được để trống',

        ];
    }
}
