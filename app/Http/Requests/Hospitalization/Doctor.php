<?php

namespace App\Http\Requests\Hospitalization;

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

        $doctor->name = $this->name;
        $doctor->email = $this->email;
        $doctor->password = bcrypt($this->password);
        $doctor->type = 2 ;

          if(count($specializations = $this->specialization))
        {
            
            foreach ($specializations as $key => $specialization_input ) {
                $this->objects['specialization'][$key] = new Specialization();
                $this->objects['specialization'][$key]->specialization = $specialization_input;
            }
        }

        $doctor->slug = str_slug($doctor->name . $specializations[0]);
        while(\App\Hospitalization\Doctor::where('slug',$doctor->slug)->first())
        {
            $doctor->slug = $doctor->slug . '-'. str_random(2);
        }
        $response = new Response();

        if ($doctor->save())
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


      public function edit($slug)
    {

        parent::edit();

        $doctor = \App\Hospitalization\Doctor::where('slug',$slug);

        $doctor->name = $this->name;
        $doctor->email = $this->email;
        $doctor->password = bcrypt($this->password); //needs edit

          if(count($specializations = $this->specialization))
        {
            
            foreach ($specializations as $key => $specialization_input ) {
                $this->objects['specialization'][$key] = new Specialization();
                $this->objects['specialization'][$key]->specialization = $specialization_input;
            }
        }

        $doctor->slug = str_slug($doctor->name .  $specializations[0]);
        while(\App\Hospitalization\Doctor::where('slug',$doctor->slug)->first())
        {
            $doctor->slug = $doctor->slug . '-'. str_random(2);
        }
        $response = new Response();

        if ($doctor->save())
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
