<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'mst_assets';

    protected $primaryKey = 'asset_id';
    
    protected $appends = ['code'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asset_region_id',
        'asset_area_id',
        'asset_point',
        'asset_type_id',
        'asset_asset_group_id',
        'asset_code',
        'asset_name',
        'asset_year',
        'asset_desc',
        'created_at',
        'updated_at'
    ];

    public function region()
    {
        return $this->belongsTo('App\Models\Masters\Region', 'asset_region_id', 'reg_id');
    }

    public function area()
    {
        return $this->belongsTo('App\Models\Masters\Area', 'asset_area_id', 'area_id');
    }

    public function tipe()
    {
        return $this->belongsTo('App\Models\Masters\AssetType', 'asset_type_id', 'type_id');
    }

    public function kelompok()
    {
        return $this->belongsTo('App\Models\Masters\AssetGroup', 'asset_asset_group_id', 'assetgrp_id');
    }

    public function getCodeAttribute()
    {
        return $this->region->reg_code.'.'.$this->area->area_code.'.'.$this->asset_point.'.'.$this->tipe->type_code.'.'.$this->asset_year.'.'. $this->asset_code;
    }
}
