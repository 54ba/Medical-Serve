<?php

namespace App\Reservation;

use Illuminate\Database\Eloquent\Model;
use App\Hosptialization\Hospital;

class Nurse extends Reservation
{

	protected $table = 'nurse_reservations'
	// type 3
    $with = 
    [
    	'reservation',
    	'hosptial'
    ];

    public function reservation()
    {
    	$this->belongsTo(Reservation::class);
    }

    public function hosptial()
    {
    	$this->reservation()->belongsTo(Hospital::class)->where('type',3);
    }

}
