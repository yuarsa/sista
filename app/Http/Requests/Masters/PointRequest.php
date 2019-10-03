<?php

namespace App\Http\Requests\Masters;

use Illuminate\Foundation\Http\FormRequest;

class PointRequest extends FormRequest
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
            'point_code' => 'required|string|min:2|max:2',
            'point_area_id' => 'required|integer',
        ];
    }

    public function attributes()
    {
        return [
            'point_code' => 'Kode',
            'point_area_id' => 'Area',
        ];
    }
}
