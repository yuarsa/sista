<?php

namespace App\Transformers\Monitor;

use App\Models\Monitors\Complaint;
use League\Fractal\TransformerAbstract;

class ComplaintTransformer extends TransformerAbstract
{
    public function transform(Complaint $complaint)
    {
        $formatted = [
            'complain_id' => $complaint->complain_id,
            'complain_code' => $complaint->complain_code,
            'complain_failure' => $complaint->complain_failure,
            'complain_name' => $complaint->complain_name,
            'complain_address' => $complaint->complain_address,
            'complain_desc' => $complaint->complain_desc,
            'complain_status' => $complaint->complain_status,
            'complain_image' => 'http://sista.jmrb.co.id/public/storage/'. $complaint->complain_image,
            'complain_image1' => 'http://sista.jmrb.co.id/public/storage/'. $complaint->complain_image1,
            'complain_image2' => 'http://sista.jmrb.co.id/public/storage/'. $complaint->complain_image2,
            'complain_image3' => 'http://sista.jmrb.co.id/public/storage/'. $complaint->complain_image3,
            'created_at' => (String) $complaint->created_at,
            'updated_at' => (String) $complaint->updated_at,
        ];

        return $formatted;
    }
}
