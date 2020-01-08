<?php

namespace App\Models\Information;


use App\Models\Hospitalization\Hospitalization;

class Specialization extends Information
{
    protected $fillable=[
        'specialization'
    ];

    public function hospitalization()
    {
        $this->belongsTo(Hospitalization::class);
    }
}
