<?php

namespace App\Hosptialization;

class Doctor extends Hospitalization
{
   
	$type =  2 ;

	$with[] = 'specialization';

    public function specialization(){
    	return this->hasMany(Specialization::class);
    }

    public function reservations(){
    	return this->hasMany(App\Reservation\Doctor::class,'hospitalization_id');
    } 

    
}
