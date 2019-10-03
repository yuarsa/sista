<?php

namespace App\Http\Requests\Masters;

use Illuminate\Foundation\Http\FormRequest;

class AssetRequest extends FormRequest
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
            'asset_region_id' => 'required|integer',
            'asset_area_id' => 'required|integer',
            'asset_point' => 'required|string',
            'asset_type_id' => 'required|integer',
            'asset_asset_group_id' => 'required|integer',
            'asset_name' => 'required|string',
            'asset_year' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'asset_region_id' => 'Region',
            'asset_area_id' => 'Rest Area',
            'asset_point' => 'Titik',
            'asset_type_id' => 'Jenis Aset',
            'asset_asset_group_id' => 'Kelompok Aset',
            'asset_name' => 'Nama Aset',
            'asset_year' => 'Tahun',
        ];
    }
}
