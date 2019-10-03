<?php

namespace App\Transformers\Master;

use App\Models\Masters\Matrik;
use League\Fractal\TransformerAbstract;

class MatrikTransformer extends TransformerAbstract
{
    public function transform(Matrik $matrik)
    {
        if($matrik->aset) {
            $aset = [
                'matrik_asset_id' => $matrik->aset->asset_id,
                'matrik_asset_name' => $matrik->aset->asset_name,
            ];
        } else {
            $aset = [
                'matrik_asset_id' => 0,
                'matrik_asset_name' => '',
            ];
        }

        if($matrik->fault) {
            $fault = [
                'matrik_fault_id' => $matrik->fault->fault_id,
                'matrik_fault_name' => $matrik->fault->fault_name,
            ];
        } else {
           $fault = [
                'matrik_fault_id' => 0,
                'matrik_fault_name' => '',
            ];
        }

        if($matrik->repair) {
            $repair = [
                'matrik_repair_id' => $matrik->repair->repair_id,
                'matrik_repair_name' => $matrik->repair->repair_name,
            ];
        } else {
            $repair = [
                'matrik_repair_id' => 0,
                'matrik_repair_name' => '',
            ];
        }

        $formatted = [
            'matrik_id' => $matrik->matrik_id,
            'aset' => $aset,
            'fault' => $fault,
            'repair' => $repair,
            'matrik_name' => $matrik->matrik_name,
            'matrik_desc' => $matrik->matrik_desc,
            'created_at' => (String) $matrik->created_at,
            'updated_at' => (String) $matrik->updated_at,
        ];

        return $formatted;
    }
}