<?php

namespace App\Transformers\Asset;

use App\Models\Masters\Asset;
use League\Fractal\TransformerAbstract;

class AssetTransformer extends TransformerAbstract
{
    public function transform(Asset $asset)
    {
        if($asset->region) {
            $region = [
                'asset_region_id' => $asset->region->reg_id,
                'asset_region_name' => $asset->region->reg_name
            ];
        } else {
            $region = [];
        }

        if($asset->area) {
            $area = [
                'asset_area_id' => $asset->area->area_id,
                'asset_area_name' => $asset->area->area_name
            ];
        } else {
            $area = [];
        }

        if($asset->tipe) {
            $tipe = [
                'asset_type_id' => $asset->tipe->type_id,
                'asset_type_code' => $asset->tipe->type_code
            ];
        } else {
            $tipe = [];
        }

        if($asset->kelompok) {
            $kelompok = [
                'asset_asset_group_id' => $asset->kelompok->assetgrp_id,
                'asset_asset_group_name' => $asset->kelompok->assetgrp_name,
            ];
        } else {
            $kelompok = [];
        }

        $formatted = [
            'asset_id' => $asset->asset_id,
            'region' => $region,
            'area' => $area,
            'asset_point' => $asset->asset_point,
			'jenis' => $tipe,
			'group' => $kelompok,
            'asset_code' => $asset->code,
            'asset_name' => $asset->asset_name,
            'asset_year' => $asset->asset_year,
            'asset_desc' => $asset->asset_desc,
            'created_at' => (String) $asset->created_at,
            'updated_at' => (String) $asset->updated_at,
        ];

        return $formatted;
    }
}
