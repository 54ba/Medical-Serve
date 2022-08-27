<?php

namespace App\Api\V1\Controllers\Hospitalization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\Hospitalization\Hospital as HospitalRequest;
use Illuminate\Support\Facades\Auth;


class HospitalController extends Controller
{

     public function createProfile(HospitalRequest $request)
    {   
       $request->store();
    }
    
     public function editProfile(HospitalRequest $request,$slug)
    {
    	if(!Auth::guard('hospitalization')->check())
    	{
			return abort(403, 'Access denied');
    	}

    	$user = Auth::guard('hospitalization')->user();
    	if($user->can('update', $slug))
    	{
    		$request->edit($slug);
    	}else
    	{
			return abort(403, 'Access denied');

    	}
    }
}
