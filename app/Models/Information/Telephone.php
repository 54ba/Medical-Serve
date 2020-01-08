<?php

namespace App\Models\Information;

use App\Models\Hospitalization\Hospitalization;

class Telephone extends Information
{
    protected $fillable=[
        'telephone'
    ];

    public function hospitalization()
    {
        $this->belongsTo(Hospitalization::class);
    }
}
