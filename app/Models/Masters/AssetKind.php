<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class AssetKind extends Model
{
    protected $table = 'mst_asset_kinds';

    protected $primaryKey = 'kind_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kind_asset_group_id', 'kind_code', 'kind_name', 'kind_desc', 'created_at', 'updated_at'
    ];

    public function kelompok()
    {
        return $this->belongsTo('App\Models\Masters\AssetGroup', 'kind_asset_group_id', 'assetgrp_id');
    }
}
