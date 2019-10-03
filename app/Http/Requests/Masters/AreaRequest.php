<?php

namespace App\Http\Requests\Masters;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
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
            'area_code' => 'required|alpha_num|min:4|max:4',
            'area_region_id' => 'required|integer',
            'area_ruas_id' => 'required|integer',
            'area_name' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'area_code' => 'Kode',
            'area_region_id' => 'Region',
            'area_ruas_id' => 'Ruas',
            'area_name' => 'Area',
        ];
    }
}
