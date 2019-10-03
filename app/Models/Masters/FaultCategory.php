<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class FaultCategory extends Model
{
    protected $table = 'mst_fault_categories';

    protected $primaryKey = 'fault_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fault_name', 'created_at', 'updated_at'
    ];
}
