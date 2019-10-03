<?php

namespace App\Transformers\Asset;

use App\Models\Masters\AssetGroup;
use League\Fractal\TransformerAbstract;

class AssetGroupTransformer extends TransformerAbstract
{
    public function transform(AssetGroup $assetGroup)
    {
        $formatted = [
            'assetgrp_id' => $assetGroup->assetgrp_id,
            'assetgrp_code' => $assetGroup->assetgrp_code,
            'assetgrp_name' => $assetGroup->assetgrp_name,
            'asssetgrp_desc' => $assetGroup->asssetgrp_desc,
            'created_at' => (String) $assetGroup->created_at,
            'updated_at' => (String) $assetGroup->updated_at,
        ];

        return $formatted;
    }
}