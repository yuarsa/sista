<?php

namespace App\Models\Monitors;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    protected $table = 'mon_inspections';

    protected $primaryKey = 'insp_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'insp_code',
        'insp_area_id',
        'insp_asset_group_id',
        'insp_asset_id',
        'insp_volume',
        'insp_matrik_id',
        'insp_desc',
        'insp_follow_up',
        'insp_status',
        'insp_image',
        'insp_image1',
        'insp_image2',
        'insp_image3',
        'insp_follow_up_image',
        'insp_follow_up_image1',
        'insp_follow_up_image2',
        'insp_follow_up_image3',
        'created_at',
        'updated_at',
    ];

    public function area()
    {
        return $this->belongsTo('App\Models\Masters\Area', 'insp_area_id', 'area_id');
    }

    public function kelompok()
    {
        return $this->belongsTo('App\Models\Masters\AssetGroup', 'insp_asset_group_id', 'assetgrp_id');
    }

    public function aset()
    {
        return $this->belongsTo('App\Models\Masters\Asset', 'insp_asset_id', 'asset_id');
    }

    public function matrik()
    {
        return $this->belongsTo('App\Models\Masters\Matrik', 'insp_matrik_id', 'matrik_id');
    }

    public function scopeBetween($query, $from , $to)
    {
        $query->whereBetween('created_at', [$from, $to]);
    }

    public function scopeOpen($query)
    {
        $query->where('insp_status', 1);
    }

    public function scopeClose($query)
    {
        $query->where('insp_status', 2);
    }
}
