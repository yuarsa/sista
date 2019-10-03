<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    protected $table = 'mst_asset_types';

    protected $primaryKey = 'type_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type_code', 'type_desc', 'created_at', 'updated_at'
    ];
}
