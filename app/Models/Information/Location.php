<?php

namespace App\Models\Information;

use App\Models\Hospitalization\Hospitalization;


class Location extends Information
{
    protected $fillable=[
        'longitude',
        'latitude'
    ];

    public function hospitalization()
    {
        $this->belongsTo(Hospitalization::class);
    }
}
