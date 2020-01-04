<?php

namespace App\Hosptialization;

class Doctor extends Hospitalization
{

	protected $table = 'doctor_hospitalizations'

   
	$with[] = 'specialization';
	$with[] = 'hospitalization';

    public function specialization(){
    	return this->hasMany(Specialization::class);
    }

    public function hospitalization()
    {
    	$this->belongsTo(Hospitalization::class);
    }

    public function reservations(){
    	return this->hasMany(App\Reservation\Doctor::class,'doctor_id');
    } 


    
}
