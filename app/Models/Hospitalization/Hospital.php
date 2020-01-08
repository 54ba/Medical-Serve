<?php

namespace App\Models\Hospitalization;

use App\Hospitalization\App;
use App\Models\Hospitalization\Hospitalization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class Hospital extends Model
{

    use SoftDeletes;
    use UUId;

    public $incrementing = false;
    protected $with =['hospitalization'];


	protected $table = 'hospital_hospitalizations';

    protected $casts = [
        'id' =>'string',
        'hospitalization_id' =>'string'
    ];

     public function hospitalization()
    {
    	$this->belongsTo(Hospitalization::class);
    }

 	 public function reservations(){
    	return $this->hasMany(App\Reservation\Nurse::class,'hospital_id');
    }

    public function delete()
    {
        $this->hospitalization()->delete();
    }

}
