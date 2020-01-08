<?php

namespace App\Models\Information;

use App\Models\Hospitalization\Hospitalization;

class Video extends Information
{
    protected $fillable=[
        'source'
    ];

    public function hospitalization()
    {
        $this->belongsTo(Hospitalization::class);
    }
}
