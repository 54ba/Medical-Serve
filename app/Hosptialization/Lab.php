<?php

namespace App\Hosptialization;


class Lab extends Hospitalization
{

	protected $table = 'lab_hospitalizations'
	$with[] = 'hospitalization';


 	public function hospitalization()
    {
    	$this->belongsTo(Hospitalization::class);
    }

	public function reservations(){
    	return this->hasMany(App\Reservation\Sample::class,'lab_id');
    } 
    
    
}
