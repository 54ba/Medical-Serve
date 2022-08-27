<?php

namespace App\Api\V1\Controllers\Hospitalization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HospitalizationController extends Controller
{

     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('hospitalization.auth', []);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function hospitalizationMe()
    {
        // auth()->shouldUse('member');

        return response()->json(auth()->guard('hospitalization')->userOrFail());
    }
}
