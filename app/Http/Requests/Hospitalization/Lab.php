<?php

namespace App\Http\Requests\Hospitalization;

use Illuminate\Http\Response;
use App\Information;

class Lab extends Hospitalization
{
    // type = 1;

     public function store()
    {

        parent::store();

        $lab = new \App\Hospitalization\Lab();

        $lab->name = $this->name;
        $lab->email = $this->email;
        $lab->password = bcrypt($this->password);
        $lab->type = 1 ;

        //TODO::Check table is slug exists
        $lab->slug = str_slug($lab->name);

         while(\App\Hospitalization\Lab::where('slug',$lab->slug)->first())
        {
            $lab->slug = $lab->slug . '-'. str_random(2);
        }

        $response = new Response();
        
        if ($lab->save())
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

        $lab = \App\Hospitalization\Lab::where('slug',$slug);

        $lab->name = $this->name;
        $lab->email = $this->email;
        $lab->password = bcrypt($this->password); //needs edit

        $lab->slug = str_slug($lab->name);
        while(\App\Hospitalization\Lab::where('slug',$lab->slug)->first())
        {
            $lab->slug = $lab->slug .'-'. str_random(2);
        }
        $response = new Response();

        if ($lab->save())
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
                            $information->hospitalization_id = $lab->id;
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
