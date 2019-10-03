<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'mst_areas';

    protected $primaryKey = 'area_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'area_code', 'area_name', 'area_region_id', 'area_ruas_id', 'area_desc', 'created_at', 'updated_at'
    ];

    public function region()
    {
        return $this->belongsTo('App\Models\Masters\Region', 'area_region_id', 'reg_id');
    }

    public function ruas()
    {
        return $this->belongsTo('App\Models\Masters\Ruas', 'area_ruas_id', 'ruas_id');
    }
}
