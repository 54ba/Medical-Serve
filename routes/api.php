<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    // users auth 
    $api->group(['prefix' => 'user-auth'], function(Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');


        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
         

        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword')->name('password.reset');

        $api->post('logout', 'App\\Api\\V1\\Controllers\\LogoutController@logout');

        $api->post('refresh', 'App\\Api\\V1\\Controllers\\RefreshController@refresh');

        $api->get('me', 'App\\Api\\V1\\Controllers\\UserController@me');



	    // Social Authentication Routes...
	   $api->get('social/redirect/{provider}', 'App\\Api\\V1\\Controllers\\SocialLoginController@redirect')->name('social.redirect');
	    $api->get('social/login/{provider}', 'App\\Api\\V1\\Controllers\\SocialLoginController@login')->name('social.login');

    });

    $api->group(['prefix' => 'hospitalization-auth'], function(Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@hospitalizationSignUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@hospitalizationLogin');
        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@hospitalizationSendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@hospitalizationResetPassword');
        $api->post('refresh', 'App\\Api\\V1\\Controllers\\RefreshController@hospitalizationRefresh');
        $api->post('logout', 'App\\Api\\V1\\Controllers\\LogoutController@hospitalizationLogout');


        $api->get('me', 'App\\Api\\V1\\Controllers\\HospitalizationController@hospitalizationreMe');

    });

    
    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
            ]);
        });

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);
    });

    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });
});
