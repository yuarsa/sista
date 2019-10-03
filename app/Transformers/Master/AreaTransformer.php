<?php

namespace App\Transformers\Master;

use App\Models\Masters\Area;
use League\Fractal\TransformerAbstract;

class AreaTransformer extends TransformerAbstract
{
    public function transform(Area $area)
    {
        if($area->region) {
            $region = [
                'area_region_id' => $area->region->reg_id,
                'area_region_name' => $area->region->reg_name,
            ];
        } else {
            $region = [];
        }

        if($area->ruas) {
            $ruas = [
                'area_ruas_id' => $area->ruas->ruas_id,
                'area_ruas_name' => $area->ruas->ruas_name,
            ];
        } else {
            $ruas = [];
        }

        $formatted = [
            'area_id' => $area->area_id,
            'area_code' => $area->area_code,
            'region' => $region,
            'ruas' => $ruas,
            'area_name' => $area->area_name,
            'area_desc' => $area->area_desc,
            'created_at' => (String) $area->created_at,
            'updated_at' => (String) $area->updated_at,
        ];

        return $formatted;
    }
}