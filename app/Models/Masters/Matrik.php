<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Matrik extends Model
{
    protected $table = 'mst_matriks';

    protected $primaryKey = 'matrik_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'matrik_group_id', 'matrik_name', 'matrik_desc', 'matrik_fault_id', 'matrik_repair_id', 'created_at', 'updated_at'
    ];

    public function kelompok()
    {
        return $this->belongsTo('App\Models\Masters\AssetGroup', 'matrik_group_id', 'assetgrp_id');
    }

    public function fault()
    {
        return $this->belongsTo('App\Models\Masters\FaultCategory', 'matrik_fault_id', 'fault_id');
    }

    public function repair()
    {
        return $this->belongsTo('App\Models\Masters\RepairCategory', 'matrik_repair_id', 'repair_id');
    }
}
