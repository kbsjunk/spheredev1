<?php

namespace Sphere;

use Illuminate\Database\Eloquent\Model;

use Exception;

class MailRecipient extends Model
{
  
    protected $casts = [
      'received_at' => 'datetime',
      'sent_at'     => 'datetime',
      'recipient'   => 'json',
    ];
  
    protected $domain = 'sandboxed3b3b7fa0d84faf8e8acbe99f8a662c.mailgun.org';
  
    public function user()
    {
      return $this->belongsTo(User::class);
    }
  
    public function site()
    {
      return $this->belongsTo(Site::class);
    }
  
    public function group()
    {
      return $this->belongsTo(Group::class);
    }
  
    public function mail()
    {
      return $this->belongsTo(Mail::class);
    }
  
    public function getHashidAttribute()
    {
      return 'hashid-'.$this->id;
    }
  
    public function findByHashid($hashid)
    {
      $id = str_replace('hashid-', '', $hashid);
      
      return self::find($id);
    }
  
    public function getAddressAttribute()
    {
      if (!$this->site && !$this->group && !$this->user) {
        foreach ($this->recipient as $actual => $name) {
            $sender = [
              'name'    => $name,
              'actual'  => $actual, 
              'address' => $this->makeNonUserAddress(),
            ];
          break;
        }
      }
      elseif ($this->user) {
          $sender = [
            'name'   => $this->user->name,
            'actual' => $this->user->email,
          ];
        
        if ($this->site) {
          if ($this->group) {
            $sender['address'] = $this->makeSiteGroupAddress($this->site, $this->group);
          }
          else {
            $sender['address'] = $this->makeSiteUserAddress($this->site, $this->user);
          }
        }
        else {
          $sender['address'] = $this->makeUserAddress($this->user);
        }
      }
      
      if (isset($sender)) {
        if ($sender['actual'] == $sender['name'] || empty($sender['name'])) {
          $sender['name'] = $this->guessNameFromAddress($sender['actual']);
        }

        return $sender;
      }
      else {
        throw new Exception('No address could be generated for mail recipient ['.$this->id.'].');
      }
      
    }
  
    public function guessNameFromAddress($address)
    {
          $name = head(explode('@', $address));
          $name = preg_split('/[^A-Za-z]+/', $name);
          $name = array_filter($name);
          return ucwords(implode(' ', $name));
    }
  
    public function makeSiteGroupAddress(Site $site, Group $group)
    {
      return $site->getRouteKey().'.groups.'.$group->getRouteKey().'@'.$this->domain;
    }
  
    public function makeSiteUserAddress(Site $site, User $user)
    {
      return $site->getRouteKey().'.users.'.$user->getRouteKey().'@'.$this->domain;
    }
  
    public function makeUserAddress(User $user)
    {
      return 'users.'.$user->getRouteKey().'@'.$this->domain;
    }
  
    public function makeNonUserAddress()
    {
      return 'anon.'.$this->hashid.'@'.$this->domain;
    }
  
    public function getRecipientType(Mail $mail)
    {
      $types = ['to', 'cc', 'bcc'];
      
      foreach ($types as $type) {
        foreach ((array) $mail->recipients[$type] as $address => $name) {
          if ($address == $this->address['address']) {
            return $type;
          }
        }
      }
      
      return 'to';
      
    }
  
    public static function getDomain($address = null)
    {
      $instance = new static;
      return ($address ? $address.'@' : null) . $instance->domain;
    }
  
    public static function firstOrNewFromAddress(Mail $mail, $address, $name = null, $type = 'to')
    {
      
      $site = false;
      $group = false;
      $user = false;
      
      if (preg_match('/^users\.(?<user>[A-Za-z0-9_-]+)@'.static::getDomain().'$/', $address, $matches)) {
        if ($user = User::where(with(new User)->getRouteKeyName(), $matches['user'])->first()) {
          $instance = static::where('site_id', null)->where('group_id', null)->where('user_id', $user->id);
        }
      }      
      elseif (preg_match('/^(?<site>[A-Za-z0-9_-]+)\.users\.(?<user>[A-Za-z0-9_-]+)@'.static::getDomain().'$/', $address, $matches)) {
        if (($site = Site::where(with(new Site)->getRouteKeyName(), $matches['site'])->first()) && 
            ($user = User::where(with(new User)->getRouteKeyName(), $matches['user'])->first())) {
          $instance = static::where('site_id', $site->id)->where('group_id', null)->where('user_id', $user->id);
        }
      }      
      elseif (preg_match('/^(?<site>[A-Za-z0-9_-]+)\.groups\.(?<user>[A-Za-z0-9_-]+)@'.static::getDomain().'$/', $address, $matches)) {
        if (($site = Site::where(with(new Site)->getRouteKeyName(), $matches['site'])->first()) && 
            ($group = Group::where(with(new Group)->getRouteKeyName(), $matches['group'])->first())) {
          dd($group, $site);//FIXME
        }
      }
      elseif($user = User::where('email', $address)->first()) {
        $instance = static::where('site_id', null)->where('group_id', null)->where('user_id', $user->id);
      }
      else {
        $instance = static::where('recipient', 'LIKE', '{"'.$address.'":"%"}');
      }
      
      if (!$instance = $instance->where('mail_id', $mail->id)->first()) {
        $instance = new static;
        $instance->recipient = [$address => $name];
        $instance->type = $type;
        if ($site) { $instance->site()->associate($site); }
        if ($group) { $instance->group()->associate($group); }
        if ($user) { $instance->user()->associate($user); }
        $instance->mail()->associate($mail);
      }
      
      return $instance;
    }
}
