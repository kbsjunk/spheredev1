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
Route::get('/dns', function () {
    
    $output = [
        'box' => dns_get_record('box,kitbs.com', DNS_CNAME),
        '.' => dns_get_record('kitbs.com', DNS_CNAME)
    ];
    
    return response()->make(json_encode($output, JSON_PRETTY_PRINT), 200, ['Content-Type' => 'text/plain']);
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

Route::get('/test/group/{groups}', function ($group) {
//     $group = Sphere\Group::find($group);
  
    return view('test.group', compact('group'));
  
    dd($group->inGroups);
    dd($group->members);
    dd($group->memberGroups);
    dd($group->memberUsers);
  
    dd($group);
})->name('test.group');

Route::get('/test/formatters/address/{countryCode}', function ($countryCode) {
    dd(app('formatter.address')->getFormat($countryCode));
});
Route::get('/test/formatters/telephone/{countryCode}', function ($countryCode) {
    dd(app('formatter.telephone')->getFormat($countryCode));
});

Route::get('/test/formatters/datetime', function () {
    
    $timezones = app('formatter.datetime')->getTimezones();
    dd($timezones);
});

Route::get('/test/formatters', function () {
    
    $countries = app('formatter.address')->getAddressFormatRepository()->getAll();
    
    $administrativeAreaTypes = [];
    $localityTypes = [];
    $dependentLocalityTypes = [];
    $postalCodeTypes = [];
    
    foreach ($countries as $country) {
        if ($country->getAdministrativeAreaType() == 'do_si') {
            dd($country);
        }
        $administrativeAreaTypes[] = $country->getAdministrativeAreaType();
        $localityTypes[] = $country->getLocalityType();
        $dependentLocalityTypes[] = $country->getDependentLocalityType();
        $postalCodeTypes[] = $country->getPostalCodeType();
    }
    
    $administrativeAreaTypes = array_filter(array_unique($administrativeAreaTypes));
    $localityTypes = array_filter(array_unique($localityTypes));
    $dependentLocalityTypes = array_filter(array_unique($dependentLocalityTypes));
    $postalCodeTypes = array_filter(array_unique($postalCodeTypes));
    
    $administrativeAreaTypes = array_combine($administrativeAreaTypes, array_map(function($item) {
        return ucwords(str_replace('_', ' ', $item));
    }, $administrativeAreaTypes));
    $localityTypes = array_combine($localityTypes, array_map(function($item) {
        return ucwords(str_replace('_', ' ', $item));
    }, $localityTypes));
    $dependentLocalityTypes = array_combine($dependentLocalityTypes, array_map(function($item) {
        return ucwords(str_replace('_', ' ', $item));
    }, $dependentLocalityTypes));
    $postalCodeTypes = array_combine($postalCodeTypes, array_map(function($item) {
        return ($item == 'postal' ? 'Postal' : strtoupper($item)) . ' Code';
    }, $postalCodeTypes));
    
    dd($administrativeAreaTypes, $localityTypes, $dependentLocalityTypes, $postalCodeTypes);
  
  
    
});

Route::get('/test/user/{users}', function ($user) {
  
  return view('test.user', compact('user'));
  
//     dd($user->inGroups);
    dd($user->inAllGroups->toArray());
  
    dd($user);
})->name('test.user');

Route::group(['middleware' => 'mailgun'], function() {

Route::post('/mail/sites/{mg_site}/groups/{mg_group}', 'MailController@siteGroup');
Route::post('/mail/sites/{mg_site}/users/{mg_user}', 'MailController@siteUser');
Route::post('/mail/users/{mg_user}', 'MailController@user');

Route::get('/mail/sites/{mg_site}/groups/{mg_group}', 'MailController@siteGroup');
Route::get('/mail/sites/{mg_site}/users/{mg_user}', 'MailController@siteUser');
Route::get('/mail/users/{mg_user}', 'MailController@user');

});

Route::get('/test/emoji', function () {
  Mail::raw(null, function ($message) {
    $message->from('sphere@sphere.loc', 'Sphere Ⓢ');//🔵
    $message->to('kit.senior@gmail.com','Kit Senior');
    $message->setBody('HTML', 'text/html');
    $message->subject('Emoji test from Sphere Ⓢ');
  });
});

Route::get('/test/recipients', function () {
  $recipients = Sphere\MailRecipient::all();
  
  $addresses = [];
  
  foreach ($recipients as $recipient) {
    $addresses[] = $recipient->address;
  }
  
  dd($addresses);
});


Route::get('test/cansend', function () {
    return view('cansend');
});