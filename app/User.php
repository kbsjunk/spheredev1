<?php

namespace Sphere;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
  
    public function getRouteKeyName()
    {
      return 'username';
    }
  
    public function getRules()
    {
      $rules = [
          'name'     => 'required|max:255',
          'email'    => 'required|email|max:255|unique:users',
          'username' => 'required|max:255|unique:users',
      ];
      
      if ($this->exists) {
        $rules['email'] .= ',email,'.$this->id;
        $rules['username'] .= ',username,'.$this->id;
      }
      
      return $rules;
    }
}
