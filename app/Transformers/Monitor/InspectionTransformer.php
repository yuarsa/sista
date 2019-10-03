<?php

namespace App\Transformers\Monitor;

use App\Models\Monitors\Inspection;
use League\Fractal\TransformerAbstract;

class InspectionTransformer extends TransformerAbstract
{
    public function transform(Inspection $inspection)
    {
        if($inspection->kelompok) {
            $kelompok = [
                'insp_asset_group_id' => $inspection->kelompok->assetgrp_id,
                'insp_asset_group_name' => $inspection->kelompok->assetgrp_name,
            ];
        } else {
            $kelompok = [
                'insp_asset_group_id' => null,
                'insp_asset_group_name' => '',
            ];
        }

        if($inspection->aset) {
            $aset = [
                'insp_asset_id' => $inspection->aset->asset_id,
                'insp_asset_name' => $inspection->aset->asset_name,
            ];
        } else {
            $aset = [
                'insp_asset_id' => null,
                'insp_asset_name' => '',
            ];
        }

        if($inspection->area) {
            $area = [
                'insp_area_id' => $inspection->area->area_id,
                'insp_area_name' => $inspection->area->area_name,
            ];
        } else {
            $area = [
                'insp_area_id' => null,
                'insp_area_name' => '',
            ];
        }

        if($inspection->matrik) {
            if($inspection->matrik->fault) {
                $fault = [
                    'fault_id' => $inspection->matrik->fault->fault_id,
                    'fault_name' => $inspection->matrik->fault->fault_name,
                ];
            } else {
                $fault = [
                    'fault_id' => '',
                    'fault_name' => ''
                ];
            }

            if($inspection->matrik->repair) {
                $repair = [
                    'repair_id' => $inspection->matrik->repair->repair_id,
                    'repair_name' => $inspection->matrik->repair->repair_name,
                ];
            } else {
                $repair = [
                    'repair_id' => '',
                    'repair_name' => ''
                ];
            }

            $matrik = [
                'insp_matrik_id' => $inspection->matrik->matrik_id,
                'insp_matrik_name' => $inspection->matrik->matrik_name,
                'fault' => $fault,
                'repair' => $repair
            ];
        } else {
            $matrik = [
                'insp_matrik_id' => null,
                'insp_matrik_name' => '',
                'fault' => '',
                'repair' => ''
            ];
        }

        $formatted = [
            'insp_id' => $inspection->insp_id,
            'insp_code' => $inspection->insp_code,
            'area' => $area,
            'kelompok' => $kelompok,
            'aset' => $aset,
            'insp_volume' => $inspection->insp_volume,
            'matrik' => $matrik,
            'insp_desc' => $inspection->insp_desc,
            'insp_status' => $inspection->insp_status,
            'insp_image' => 'http://sista.jmrb.co.id/public/storage/'.$inspection->insp_image,
            'insp_image1' => 'http://sista.jmrb.co.id/public/storage/'. $inspection->insp_image1,
            'insp_image2' => 'http://sista.jmrb.co.id/public/storage/'. $inspection->insp_image2,
            'insp_image3' => 'http://sista.jmrb.co.id/public/storage/'. $inspection->insp_image3,
            'created_at' => (String) $inspection->created_at,
            'updated_at' => (String) $inspection->updated_at,
        ];

        return $formatted;
    }
}
