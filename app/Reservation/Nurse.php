<?php

namespace App\Reservation;

use Illuminate\Database\Eloquent\Model;
use App\Hosptialization\Hospital as Hospital;
class Nurse extends Reservation
{

	protected $table = 'nurse_reservations'

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
    	$this->belongsTo(Hospital::class);
    }

}
