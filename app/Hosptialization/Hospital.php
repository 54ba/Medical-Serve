<?php

namespace App\Hosptialization;


class Hospital extends Hospitalization
{
    
 	$type = 3;

 	 public function reservations(){
    	return this->hasMany(App\Reservation\Nurse::class,'hospitalization_id');
    } 
}
