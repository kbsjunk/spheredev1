<?php

namespace Sphere;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
  
    protected $_inherited = false;
  
    protected $appends = ['inherited'];
    
    protected $with = ['customValues'];
  
    protected $customFields = [];
  
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
  
    public function mailRecipients()
    {
        return $this->hasMany(MailRecipient::class);
    }
  
    public function mails()
    {
        return $this->hasManyThrough(Mail::class, MailRecipient::class);
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
  
  public function users()
  {
    return $this->belongsToMany(User::class);
  }
  
    public function customValues()
    {
      return $this->morphToMany(Attribute::class, 'attributable', 'attribute_value')->withPivot(['value'])->withTimestamps();
    }
  
    protected function appendCustomFields()
    {
      foreach ($this->getCustomFields() as $attribute) {
        $this->append($attribute->slug);
      } 
    }
  
    public function getCustomFields()
    {
      if (empty($this->customFields)) {
        
      $class = $this->getMorphClass();
      
        $this->customFields = Attribute::join('attribute_entity', function($join) use ($class) {
          $join->on('attributes.id', '=', 'attribute_entity.attribute_id')
            ->where('attributable_type', '=', $class);
        })->get();
      }
      
      return $this->customFields;
    }
  
    public function inGroups()
    {
      return $this->morphToMany(Group::class, 'groupable');
    }
  
    public function getInAllGroupsAttribute()
    {
      $allGroups = $this->inGroups;
      
      foreach ($this->inGroups as $thisGroup) {
        $this->addParentGroups($thisGroup, $allGroups);
      }
            
      return $allGroups->unique();
    }
  
    private function addParentGroups($group, &$allGroups)
    {
      foreach ($group->inGroups as $thisGroup) {
        $thisGroup->indirect = $group;
        $allGroups->add($thisGroup);
        $this->addParentGroups($thisGroup, $allGroups);
      }
    }
  
    public function getInheritedAttribute()
    {
      return $this->_inherited;
    }
  
    public function setInheritedAttribute($inherited)
    {
      $this->_inherited = $inherited;
    }
  
    public function getAttribute($key)
    {
        $display = false;
      
        if (ends_with($key, '_display')) {
          $display = true;
          $key = substr($key, 0, strlen($key) - 8);
        }
      
        if ($this->getCustomFields()->pluck('slug')->contains($key)) {
          return $this->getCustomValue($key, $display);
        }
      
      return parent::getAttribute($key);
    }

    public function getCustomValue($key, $default = null)//, $display = false) //CHANGED
    {
      @list($key, $subkeys) = explode('.', $key, 2);
        
      foreach ($this->customValues as $attribute) {
        if ($attribute->slug == $key) {
//           return $display ? $attribute->display_value : $attribute->value;
          $value = $attribute->value;
          
          if ($subkeys && is_array($value)) {
              $value = array_get($value, $subkeys); //CHANGED
          }
          
          return $value;
        }
      }
        
        return $default;
    }
    
  public function sites()
  {
    return $this->belongsToMany(Site::class);
  }
}
