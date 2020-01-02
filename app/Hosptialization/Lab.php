<?php

namespace App\Hosptialization;


class Lab extends Hospitalization
{

	$type = 1;

	public function reservations(){
    	return this->hasMany(App\Reservation\Sample::class,'hospitalization_id');
    } 
    
    
}
