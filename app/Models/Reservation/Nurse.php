<?php

namespace App\Models\Reservation;

use App\Models\Reservation\Reservation;
use Illuminate\Database\Eloquent\Model;
use App\Hosptialization\Hospital as Hospital;
class Nurse extends Reservation
{

	protected $table = 'nurse_reservations';

    protected $with =
    [
    	'reservation',
    	'hospital'
    ];

    public function reservation()
    {
    	return $this->belongsTo(Reservation::class);
    }

    public function hospital()
    {
    	return $this->belongsTo(Hospital::class);
    }

    public function delete()
    {
        $this->reservation()->delete();
    }

}
