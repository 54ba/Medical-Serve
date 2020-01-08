<?php

namespace App\Models\Hospitalization;

use App\Hospitalization\App;
use App\Models\Hospitalization\Hospitalization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class Lab extends Model
{

	use SoftDeletes;
    use UUId;

	public $incrementing = false;

	protected $table = 'lab_hospitalizations';

	protected $with =['hospitalization'];

	protected $casts = [
		'id' =>'string',
        'hospitalization_id' =>'string'
    ];

 	public function hospitalization()
    {
    	return $this->belongsTo(Hospitalization::class,'hospitalization_id');
    }

	public function reservations(){
    	return $this->hasMany(App\Reservation\Sample::class,'lab_id');
    }

    public function delete()
    {
        $this->hospitalization()->delete();
    }



}
