<?php

namespace App\Api\V1\Requests\Hospitalization;

use Illuminate\Http\Response;
use App\Information;

class Doctor extends Hospitalization
{
    //type 2

     public function rules()
    {

        return parent::rules() + 
        [
           'specialization'=> 'required|array|min:1',
           'specialization.*' => 'distinct|min:1|max:500',
        ];
    }

    public function messages()
    {
        return parent::messages() + 
        [
            'specialization.required' => 'الرجاء ادخال التخصص',
        ];
    }

     public function store()
    {

        parent::store();

        $doctor = new \App\Hospitalization\Doctor();
        $hospitalization = new \App\Hospitalization\Hospitalization();

        $hospitalization->name = $this->name;
        $hospitalization->email = $this->email;
        $hospitalization->password = bcrypt($this->password);

          if(count($specializations = $this->specialization))
        {
            
            foreach ($specializations as $key => $specialization_input ) {
                $this->objects['specialization'][$key] = new Specialization();
                $this->objects['specialization'][$key]->specialization = $specialization_input;
            }
        }

        $hospitalization->slug = str_slug($hospitalization->name . $specializations[0]);
        while(\App\Hospitalization\Hospitalization::where('slug',$hospitalization->slug)->first())
        {
            $hospitalization->slug = $hospitalization->slug . '-'. str_random(2);
        }
        $response = new Response();
        

        if ($hospitalization->save())
        {
            $doctor->hospitalization = $hospitalization;
            if ( $doctor->save())
            {
                
                try
                {
                     foreach ($this->objects as $object) 
                    {

                        if(is_array($object) && count($object))
                        {   
                            //object is array of objects

                            array_map(function($information)
                            {
                                $information->hospitalization_id = $doctor->id;
                                $information->save();

                            }, $object);
                        }elseif (null != $object && !empty($object) )
                        {
                            
                        }
                    }
                }catch(e)
                {
                    $response->status = $response::HTTP_INTERNAL_SERVER_ERROR ;
                    return Response::json($response);
                }


                $response->status = $response::HTTP_OK;
                return Response::json($response);
            }
        }

        $response->status = $response::HTTP_INTERNAL_SERVER_ERROR ;
        return Response::json($response);

    }


      public function edit($slug)
    {

        parent::edit();

        $doctor = \App\Hospitalization\Doctor::where('slug',$slug)->firstOrFail();

        $doctor->hospitalization->name = $this->name;
        $doctor->hospitalization->email = $this->email;
        $doctor->hospitalization->password = bcrypt($this->password); //needs edit

          if(count($specializations = $this->specialization))
        {
            
            foreach ($specializations as $key => $specialization_input ) {
                $this->objects['specialization'][$key] = new Specialization();
                $this->objects['specialization'][$key]->specialization = $specialization_input;
            }
        }

        $doctor->hospitalization->slug = str_slug($doctor->hospitalization->name .  $specializations[0]);
        while(\App\Hospitalization\Hospitalization::where('slug',$hospitalization->slug)->first())
        {
            $doctor->hospitalization->slug = $doctor->hospitalization->slug . '-'. str_random(2);
        }
        $response = new Response();

        if ($doctor->hospitalization->save() && $doctor->save())
        {
            try
            {
                 foreach ($this->objects as $object) 
                {

                    if(is_array($object) && count($object))
                    {   
                        //object is array of objects

                        array_map(function($information)
                        {
                            $information->hospitalization_id = $doctor->id;
                            $information->save();

                        }, $object);
                    }elseif (null != $object && !empty($object) )
                    {
                        
                    }
                }
            }catch(e)
            {
                $response->status = $response::HTTP_INTERNAL_SERVER_ERROR ;
                return Response::json($response);
            }


            $response->status = $response::HTTP_OK;
            return Response::json($response);
        }

        $response->status = $response::HTTP_INTERNAL_SERVER_ERROR ;
        return Response::json($response);

    }
}
