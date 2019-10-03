<?php

namespace App\Http\Requests\Masters;

use Illuminate\Foundation\Http\FormRequest;

class AssetKindRequest extends FormRequest
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
            'kind_code' => 'required|string|min:2|max:2',
            'kind_name' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'kind_code' => 'Kode',
            'kind_name' => 'Nama',
        ];
    }
}
