<?php

namespace App\Models\Reservation;

use App\Models\Reservation\Reservation;
use Illuminate\Database\Eloquent\Model;
use App\Hosptialization\Doctor as HospitalizationDoctor;

class Doctor extends Reservation
{

    protected $table = 'doctor_reservations';

      protected $with =
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
    	$this->belongsTo(HospitalizationDoctor::class);
    }

    public function delete()
    {
        $this->reservation()->delete();
    }
}


