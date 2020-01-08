<?php

namespace App\Models\Information;

use App\Models\Hospitalization\Hospitalization;

class Address extends Information
{
    protected $fillable=[
        'address'
    ];

    public function hospitalization()
    {
        $this->belongsTo(Hospitalization::class);
    }
}
