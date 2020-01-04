<?php

namespace App\Reservation;

use Illuminate\Database\Eloquent\Model;
use App\Hosptialization\Lab as Lab;

class Sample extends Reservation
{
	protected $table = 'sample_reservations'

      $with = 
    [
        'reservation',
    	'lab'
    ];

    public function reservation()
    {
        $this->belongsTo(Reservation::class);
    }
    public function lab()
    {
    	$this->belongsTo(Lab::class);
    }
}


