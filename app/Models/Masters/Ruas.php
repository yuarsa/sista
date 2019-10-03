<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Ruas extends Model
{
    protected $table = 'mst_ruas';

    protected $primaryKey = 'ruas_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ruas_region_id', 'ruas_code', 'ruas_name', 'ruas_desc', 'created_at', 'updated_at'
    ];

    public function region()
    {
        return $this->belongsTo('App\Models\Masters\Region', 'ruas_region_id', 'reg_id');
    }
}
