<?php

namespace App\Hosptialization;


class Hospital extends Hospitalization
{

	
	protected $table = 'hospital_hospitalizations'
	$with[] = 'hospitalization';

    
     public function hospitalization()
    {
    	$this->belongsTo(Hospitalization::class);
    }

 	 public function reservations(){
    	return this->hasMany(App\Reservation\Nurse::class,'hospital_id');
    } 
}
