<?php

namespace App\Reservation;

use Illuminate\Database\Eloquent\Model;
use App\Hosptialization\Doctor as Doctor;

class Doctor extends Reservation
{

    protected $table = 'dcotor_reservations'

      $with = 
    [
    	'reservation',
    	'doctor'
    ];


	public function reservation()
    {
    	$this->belongsTo(Reservation::class);
    }
    public function doctor()
    {
    	$this->belongsTo(Doctor::class);
    }
}


