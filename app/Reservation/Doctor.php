<?php

namespace App\Reservation;

use Illuminate\Database\Eloquent\Model;
use App\Hosptialization\Doctor;

class Doctor extends Reservation
{


	//type 2
      $with = 
    [
    	'doctor'
    ];


    public function doctor()
    {
    	$this->belongsTo(Doctor::class)->where('type',2);
    }
}


