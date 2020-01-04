<?php

namespace App\Api\V1\Controllers\Hosptialization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HosptializationController extends Controller
{

     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', []);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function hospitalizationreMe()
    {
        return response()->json(Auth::guard('hospitalization')->user());
    }
}
