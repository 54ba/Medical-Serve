<?php

namespace App\Models\Reservation;

use App\Models\Reservation\Reservation;
use Illuminate\Database\Eloquent\Model;
use App\Hosptialization\Lab as Lab;

class Sample extends Reservation
{
	protected $table = 'sample_reservations';

      protected $with =
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

    public function delete()
    {
        $this->reservation()->delete();
    }
}


