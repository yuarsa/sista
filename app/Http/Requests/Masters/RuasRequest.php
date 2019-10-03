<?php

namespace App\Http\Requests\Masters;

use Illuminate\Foundation\Http\FormRequest;

class RuasRequest extends FormRequest
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
            'ruas_region_id' => 'required|integer',
            'ruas_code' => 'required|string',
            'ruas_name' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'ruas_region_id' => 'Region',
            'ruas_code' => 'Kode',
            'ruas_name' => 'Nama',
        ];
    }
}
