<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class RepairCategory extends Model
{
    protected $table = 'mst_repair_categories';

    protected $primaryKey = 'repair_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'repair_name', 'created_at', 'updated_at'
    ];
}
