<?php

namespace Sphere;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{   
  
    protected $_inherited = false;
  
    protected $appends = ['inherited'];
  
    public function getRouteKeyName()
    {
      return 'slug';
    }
  
    public function site()
    {
      return $this->belongsTo(Site::class);
    }
  
    public function mailRecipients()
    {
        return $this->hasMany(MailRecipient::class);
    }
  
    public function mails()
    {
        return $this->hasManyThrough(Mail::class, MailRecipient::class);
    }
  
    public function memberGroups()
    {
      return $this->morphedByMany(Group::class, 'groupable');
    }
  
    public function memberUsers()
    {
      return $this->morphedByMany(User::class, 'groupable');
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
            
      return $allGroups;//->unique();
    }
  
    private function addParentGroups($group, &$allGroups)
    {
      foreach ($group->inGroups as $thisGroup) {
        $thisGroup->indirect = $group;
        $allGroups->add($thisGroup);
        $this->addParentGroups($thisGroup, $allGroups);
      }
    }
  
    private function addChildUsers($group, &$allUsers)
    {
      foreach ($group->memberGroups as $thisGroup) {
        foreach ($thisGroup->memberUsers as $thisUser) {
          $thisUser->indirect = $group;
          $allUsers->add($thisUser);
        }
        $this->addChildUsers($thisGroup, $allUsers);
      }
    }
  
    private function addChildGroups($group, &$allGroups)
    {
      foreach ($group->memberGroups as $thisGroup) {
        $thisGroup->indirect = $group;
        $allGroups->add($thisGroup);
        $this->addChildGroups($thisGroup, $allGroups);
      }
    }
  
    public function getMembersAttribute()
    {
      return $this->memberGroups->merge($this->memberUsers);
    }
  
    public function getAllMembersAttribute()
    {
      return $this->allMemberGroups->merge($this->allMemberUsers);
    }
  
    public function getAllMemberUsersAttribute()
    {
      $allUsers = $this->newCollection();
      
      foreach ($this->memberGroups as $thisGroup) {
        foreach ($thisGroup->memberUsers as $thisUser) {
          $thisUser->indirect = $thisGroup;
          $allUsers->add($thisUser);
        }
        $this->addChildUsers($thisGroup, $allUsers);
      }
      
      $allUsers = $this->memberUsers->merge($allUsers);
      
      return $allUsers;//->unique();
    }
  
    public function getAllMemberGroupsAttribute()
    {
      $allGroups = $this->newCollection();
      
      foreach ($this->memberGroups as $thisGroup) {
        $allGroups->add($thisGroup);
        $this->addChildGroups($thisGroup, $allGroups);
      }
      
      return $allGroups;//->unique();
    }
  
    public function getInheritedAttribute()
    {
      return $this->_inherited;
    }
  
    public function setInheritedAttribute($inherited)
    {
      $this->_inherited = $inherited;
    }
  
    public function canBeParent(Group $parent)
    {
      
      if ($this->id == $parent->id) {
        return false;
      }
      
      $allMyChildren = $this->allMemberGroups->pluck('id')->unique();
//       $allMyParents = $this->inAllGroups->pluck('id')->unique();
      
//       $allParentChildren = $parent->allMemberGroups->pluck('id')->unique();
      $allParentParents = $parent->inAllGroups->pluck('id')->unique();
            
      $overlap = $allMyChildren->push($this->id)->intersect($allParentParents);
//         ->merge($allParentChildren->intersect($allMyParents->push($parent->id)));
      
      return $overlap->count() == 0;
      
    }
  
    public function canBeChild(Group $child)
    {
      
      if ($this->id == $child->id) {
        return false;
      }
      
//       $allMyChildren = $this->allMemberGroups->pluck('id')->unique();
      $allMyParents = $this->inAllGroups->pluck('id')->unique();
      
      $allChildChildren = $child->allMemberGroups->pluck('id')->unique();
//       $allChildParents = $child->inAllGroups->pluck('id')->unique();
            
      $overlap = $allChildChildren->push($this->id)->intersect($allMyParents);
//         ->merge($allChildChildren->intersect($allMyParents->push($child->id)));
      
      return $overlap->count() == 0;
      
    }
  
  
}
