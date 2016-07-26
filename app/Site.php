<?php

namespace Sphere;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
  public function getRouteKeyName()
  {
    return 'slug';
  }
  
  public function groups()
  {
    return $this->hasMany(Group::class);
  }
  
  public function users()
  {
    return $this->belongsToMany(User::class);
  }
  
    public function mailRecipients()
    {
        return $this->hasMany(MailRecipient::class);
    }
  
    public function mails()
    {
        return $this->hasManyThrough(Mail::class, MailRecipient::class);
    }
}
