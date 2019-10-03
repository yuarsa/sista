<?php

namespace App\Models\Monitors;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'mon_complaints';

    protected $primaryKey = 'complain_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'complain_code',
        'complain_failure',
        'complain_name',
        'complain_address',
        'complain_desc',
        'complain_status',
        'complain_image',
        'complain_image1',
        'complain_image2',
        'complain_image3',
        'complain_follow_up',
        'complain_follow_up_image',
        'complain_follow_up_image1',
        'complain_follow_up_image2',
        'complain_follow_up_image3',
        'created_at',
        'updated_at',
    ];

    public function scopeBetween($query, $from , $to)
    {
        $query->whereBetween('created_at', [$from, $to]);
    }

    public function scopeOpen($query)
    {
        $query->where('complain_status', 1);
    }

    public function scopeClose($query)
    {
        $query->where('complain_status', 2);
    }
}
