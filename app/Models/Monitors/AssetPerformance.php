<?php

namespace App\Models\Monitors;

use Illuminate\Database\Eloquent\Model;

class AssetPerformance extends Model
{
    protected $table = 'mon_asset_performances';

    protected $primaryKey = 'assetperf_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'assetperf_asset_group_id',
        'assetperf_asset_id',
        'assetperf_code',
        'assetperf_name',
        'assetperf_is_work',
        'assetperf_desc',
        'assetperf_percentage',
        'assetperf_shift',
        'created_at',
        'updated_at'
    ];

    public function kelompok()
    {
        return $this->belongsTo('App\Models\Masters\AssetGroup', 'assetperf_asset_group_id', 'assetgrp_id');
    }

    public function aset()
    {
        return $this->belongsTo('App\Models\Masters\Asset', 'assetperf_asset_id', 'asset_id');
    }

    public function scopeBetween($query, $from , $to)
    {
        $query->whereBetween('created_at', [$from, $to]);
    }

    public function scopeEnabled($query)
    {
        $query->whereBetween('assetperf_is_work', 1);
    }

    public function scopeDisabled($query)
    {
        $query->whereBetween('assetperf_is_work', 2);
    }
}
