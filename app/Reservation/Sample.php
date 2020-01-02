<?php

namespace App\Reservation;

use Illuminate\Database\Eloquent\Model;
use App\Hosptialization\Lab;


class Sample extends Reservation
{
	//type 1
	
      $with = 
    [
    	'lab'
    ];

    public function lab()
    {
    	$this->belongsTo(Lab::class)->where('type',1);
    }
}


