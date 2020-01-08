<?php

namespace App\Api\V1\Controllers\Hospitalization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\Hospitalization\Doctor as DoctorRequest;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{

     public function createProfile(DoctorRequest $request)
    {   
       $request->store();
    }

    public function editProfile(DoctorRequest $request,$slug)
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
