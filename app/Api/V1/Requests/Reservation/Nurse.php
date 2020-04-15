<?php

namespace App\Api\V1\Requests\Reservation;

use App\Api\V1\Requests\Reservation\Reservation;
use Illuminate\Http\Response;

class Nurse extends Reservation
{


public function rules()
    {
       return parent::rules() +
        [
            'gender' => 'required|String|min:1|max:191|not_in:0'
        ];
    }

 public function messages()
    {
        return parent::messages() +
        [
            'slug.required' => 'الرجاء اختيار  المستشفي',
            'gender.required'=> 'الرجاء اختيار جنس الممرض'
        ];
    }

     public function store()
    {
        $reservation = new \App\Models\Reservation\Reservation();

        $reservation->name = $this->name;
        $reservation->mobile_number = $this->mobile_number;
        $reservation->telephone = $this->age;

        $hospitalization = \App\Models\Hospitalization\Hospital::where('slug',$this->slug)->first();
        $reservation->hospitalization_id = $hospitalization->id;

        $response = new Response();


        if ($reservation->save())
        {
            $nurse = new \App\Models\Reservation\Nurse();
            $nurse->gender = $this->gender;
            if($nurse->save())
            {
                $response->status = $response::HTTP_OK;

                return Response::json($response);
            }

        }

        $response->status = $response::HTTP_INTERNAL_SERVER_ERROR ;

        return Response::json($response);
    }

}
