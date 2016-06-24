<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function() {
  Route::get('/home', function () {
    return view('home');
  });
  
  Route::resource('users', 'UsersController');
  
  Route::get('/@{userOrSite}', function($userOrSite) {
    
    if ($user = Sphere\User::where('username', $userOrSite)->first()) {
      return redirect()->route('users.show', $user);
    }
    elseif ($site = Sphere\Site::where('domain', $userOrSite)->first()) {
      return redirect()->route('sites.show', $site);
    }
    
    abort(404);
    
  });
  
});



Route::auth();