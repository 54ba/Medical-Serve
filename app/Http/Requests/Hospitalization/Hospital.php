<?php

namespace App\Http\Requests\Hospitalization;

use Illuminate\Http\Response;
use App\Information;

class Hospital extends Hospitalization
{
    // type = 3;

     public function store()
    {

        parent::store();

        $hospital = new \App\Hospitalization\Hospital();

        $hospital->name = $this->name;
        $hospital->email = $this->email;
        $hospital->password = bcrypt($this->password);
        $hospital->type = 3 ;


        $hospital->slug = str_slug($hospital->name);
        
        while(\App\Hospitalization\Hospital::where('slug',$hospital->slug)->first())
        {
            $hospital->slug = $hospital->slug . '-'. str_random(2);
        }

        $response = new Response();
        
        if ($hospital->save())
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
                            $information->hospitalization_id = $hospital->id;
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

        $hospital = \App\Hospitalization\Hospital::where('slug',$slug);

        $hospital->name = $this->name;
        $hospital->email = $this->email;
        $hospital->password = bcrypt($this->password); //needs edit

        $hospital->slug = str_slug($hospital->name);
        while(\App\Hospitalization\Hospital::where('slug',$hospital->slug)->first())
        {
            $hospital->slug = $hospital->slug .'-'. str_random(2);
        }
        $response = new Response();

        if ($hospital->save())
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
                            $information->hospitalization_id = $hospital->id;
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
