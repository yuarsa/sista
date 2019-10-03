<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'mst_regions';

    protected $primaryKey = 'reg_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reg_code', 'reg_name', 'reg_desc', 'created_at', 'updated_at'
    ];
}
