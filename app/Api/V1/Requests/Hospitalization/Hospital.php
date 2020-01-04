<?php

namespace App\Api\V1\Requests\Hospitalization;

use Illuminate\Http\Response;
use App\Information;

class Hospital extends Hospitalization
{

     public function store()
    {

        parent::store();

        $hospital = new \App\Hospitalization\Hospital();
        $hospitalization = new \App\Hospitalization\Hospitalization();

        $hospitalization->name = $this->name;
        $hospitalization->email = $this->email;
        $hospitalization->password = bcrypt($this->password);

        $hospitalization->slug = str_slug($hospitalization->name);
        
        while(\App\Hospitalization\Hospitalization::where('slug',$hospitalization->slug)->first())
        {
            $hospitalization->slug = $hospitalization->slug . '-'. str_random(2);
        }

        $response = new Response();
        
        if ($hospitalization->save())
            {
                $hospital->hospitalization = $hospitalization;
                if ( $hospital->save())
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
            }

        $response->status = $response::HTTP_INTERNAL_SERVER_ERROR ;
        return Response::json($response);

    }


      public function edit($slug)
    {

        parent::edit();

        $hospital = \App\Hospitalization\Hospital::where('slug',$slug)->firstOrFail();

        $hospital->hospitalization->name = $this->name;
        $hospital->hospitalization->email = $this->email;
        $hospital->hospitalization->password = bcrypt($this->password); //needs edit

        $hospital->hospitalization->slug = str_slug($hospital->name);
        while(\App\Hospitalization\Hospitalization::where('slug',$hospital->hospitalization->slug)->first())
        {
            $hospital->hospitalization->slug = $hospital->hospitalization->slug .'-'. str_random(2);
        }
        $response = new Response();

        if ($hospital->hospitalization->save() && $hospital->save())
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
