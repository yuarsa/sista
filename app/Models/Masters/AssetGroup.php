<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class AssetGroup extends Model
{
    protected $table = 'mst_asset_groups';

    protected $primaryKey = 'assetgrp_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'assetgrp_code', 'assetgrp_name', 'asssetgrp_desc', 'created_at', 'updated_at'
    ];
}
