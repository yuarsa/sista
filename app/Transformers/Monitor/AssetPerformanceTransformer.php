<?php

namespace App\Transformers\Monitor;

use App\Models\Monitors\AssetPerformance;
use League\Fractal\TransformerAbstract;

class AssetPerformanceTransformer extends TransformerAbstract
{
    public function transform(AssetPerformance $assetPerformance)
    {
        if($assetPerformance->kelompok) {
            $kelompok = [
                'assetperf_asset_group_id' => $assetPerformance->kelompok->assetgrp_id,
                'assetperf_asset_group_name' => $assetPerformance->kelompok->assetgrp_name,
            ];
        } else {
            $kelompok = [];
        }

        if($assetPerformance->aset) {
            $aset = [
                'assetperf_asset_id' => $assetPerformance->aset->asset_id,
                'assetperf_asset_name' => $assetPerformance->aset->asset_name,
            ];
        } else {
            $aset = [];
        }

        $formatted = [
            'assetperf_id' => $assetPerformance->assetperf_id,
            'kelompok' => $kelompok,
            'aset' => $aset,
            'assetperf_code' => $assetPerformance->assetperf_code,
            'assetperf_is_work' => $assetPerformance->assetperf_is_work,
            'assetperf_desc' => $assetPerformance->assetperf_desc,
            'assetperf_percentage' => (double) $assetPerformance->assetperf_percentage,
            'assetperf_shift' => $assetPerformance->assetperf_shift,
            'created_at' => (String) $assetPerformance->created_at,
            'updated_at' => (String) $assetPerformance->updated_at,
        ];

        return $formatted;
    }
}
