<?php

namespace App\Http\Requests\Masters;

use Illuminate\Foundation\Http\FormRequest;

class RegionRequest extends FormRequest
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
            'reg_code' => 'required|string|min:3|max:3',
            'reg_name' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'reg_code' => 'Kode',
            'reg_name' => 'Nama',
        ];
    }
}
