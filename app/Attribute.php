<?php

namespace Sphere;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $casts = [
      'options'  => 'json',
      'settings' => 'json',
    ];
    
    public function getHashidAttribute()
    {
        return $this->slug;//'attr_'.$this->id;
    }
  
    public function users()
    {
      return $this->morphedByMany(User::class, 'attributable');
    }
  
    public function groups()
    {
      return $this->morphedByMany(Group::class, 'attributable');
    }
  
    public function getValueAttribute()
    {
      $value = $this->pivot->value;
      
        if (is_null($value)) {
            return null;
        }
        
        switch ($this->type) {
            case 'integer':
                return (int) $value;
            case 'double':
                return (float) $value;
            case 'text':
            case 'textarea':
            case 'email':
            case 'url':
            case 'select':
                return (string) $value;
            case 'boolean':
            case 'checkbox':
                return (bool) $value;
            case 'multiple':
            case 'checkboxes':
            case 'address':
            case 'tel':
                return (array) $this->fromJson($value);
            case 'date':
            case 'datetime':
                return $this->asDateTime($value);
            default:
                return $value;
        }
    }
  
    public function getDefaultAttribute()
    {
        $value = $this->attributes['default'];
      
        if (is_null($value)) {
            return $value;
        }
      
        switch ($this->type) {
            case 'integer':
                return (int) $value;
            case 'double':
                return (float) $value;
            case 'text':
            case 'textarea':
            case 'email':
            case 'url':
            case 'select':
                return (string) $value;
            case 'boolean':
            case 'checkbox':
            case 'radio':
                return (bool) $value;
            case 'multiple':
            case 'checkboxes':
            case 'address':
            case 'tel':
                return $this->fromJson($value);
            case 'date':
            case 'datetime':
                return $this->asDateTime($value);
            default:
                return $value;
        }
    }
  
    public function getViewKey()
    {
      
      switch ($this->type) {
        case 'text';
        case 'color';
        case 'email';
        case 'password';
        case 'url';         
          $type = 'text';
          break;
        default:
            $type = $this->type;
      }
      
      return 'custom_fields.'.$type;
    }
  
    public function isPreWrapped() //CHANGED
    {
//       switch ($this->type) {
//         case 'address';
//         case 'datetime';
//           return true;
//           break;
//       }
      
      return false;
    }
  
    public function getView(Model $entity) //CHANGED
    {
      $field = $this;
      $type = $this->type;
      $data = compact('field', 'entity', 'type');
      
      if ($this->isPreWrapped()) {
        return view($this->getViewKey(), $data);
      }
      else {
        return view('custom_fields._before', $data).view($this->getViewKey(), $data).view('custom_fields._after', $data);
      }
    }
  
    public function getLabelAttribute($label)
    {
      return $label ?: $this->name;
    }
  
    public function getPlaceholderAttribute($placeholder)
    {
      return $placeholder ?: $this->label;
    }
    
    public function getSetting($setting, $default = null)
    {
        $settings = $this->getSettings();
        
        return array_get($settings, $setting, $default);
    }
    
    public function getChunks()
    {
        return ceil(count($this->options) / (int) $this->getSetting('cols'));
    }
    
    public function getColWidth()
    {
        $width = round(12 / (int) $this->getSetting('cols'), 0);
        
        if (!in_array($width, [12, 6, 4, 3, 2, 1], true)) {
            return 12;
        }
        
        return $width;
    }
    
    public function getSettings()
    {
        switch ($this->type) {
            case 'checkboxes':
            case 'radios':
                $settings = [
                    'height' => 300,
                ];
                break;
            default:
                $settings = [];
        }
        
        return array_merge($settings, (array) $this->settings);
    }
  
    public function getDisplayValueAttribute()
    {
        $value = $this->value;
      
        if (is_null($value)) {
            return $value;
        }
      
        switch ($this->type) {
           case 'select':
              return $this->getOption($value);
            case 'multiple':
            case 'checkboxes':
                return $this->getOptions($value);
          case 'date':
          case 'datetime':
            return (string) $value;
            default:
                return $value;
        }
    }
  
    public function getDisplayDefaultAttribute()
    {
        $value = $this->default;
      
        if (is_null($value)) {
            return $value;
        }
      
        switch ($this->type) {
           case 'select':
              return $this->getOption($value);
            case 'multiple':
            case 'checkboxes':
                return $this->getOptions($value);
          case 'date':
          case 'datetime':
            return (string) $value;
            default:
                return $value;
        }
    }
  
    public function getIsMultipleAttribute()
    {
      return $this->type == 'multiple' || $this->type == 'checkboxes' || $this->type == 'address';
    }
  
    public function getOptions($value)
    {
      return array_values(array_only($this->options, (array) $value));
    }
  
    public function getOption($value)
    {
      return array_get($this->options, $value);
    }
  
    public function setValueAttribute($value)
    {
     
        switch ($this->type) {
            case 'integer':
                $value = (int) $value;
            case 'double':
                $value = (float) $value;
            case 'string':
            case 'select':
                $value = (string) $value;
            case 'boolean':
            case 'checkbox':
                $value = (bool) $value;
            case 'multiple':
            case 'checkboxes':
            case 'address':
            case 'tel':
                $value = $this->toJson($value);
            case 'date':
            case 'datetime':
                $value = $this->fromDateTime($value);
        }
      
      $this->pivot->attributes['value'] = $value;
    }
  
  public function save(array $options = [])
  {
    return $this->push();
  }
  
  public function getSlug($subfield = null)//CHANGED
  {
    return 'custom_fields_'.$this->hashid . ($subfield ? '_'.$subfield : null);
  }
  
  public function getName($subfield = null)//CHANGED
  {
    return 'custom_fields['.$this->hashid .']'. ($subfield ? '['.$subfield.']' : null);
  }
  
  public function getDot($subfield = null)//CHANGED
  {
    return $this->hashid . ($subfield ? '.'.$subfield : null);
  }
  
  public function getHelp($subfield = null)//CHANGED
  {
    $helps = json_decode($this->help, true);
    
    if ($subfield && is_array($helps)) {
      return array_get($helps, $subfield);
    }
    
    return $this->help;
  }
  
  public function getLabel($subfield = null)//CHANGED
  {
    $labels = json_decode($this->label, true);
    
    if ($subfield && is_array($labels)) {
      return array_get($labels, $subfield);
    }
    
    return $this->label;
  }
    
  public function getValue($entity, $subfield = null)
  {
      return old('custom_fields.'.$this->getDot($subfield), $entity->getCustomValue($this->getDot($subfield), $this->getDefaultValue($subfield)));
  }
    
    public function getDefaultValue($subfield = null)
    {
        $default = $this->default;
        
        if ($subfield && is_array($default)) {
            return array_get($default, $subfield);
        }
        
        return $default;
    }
    
    public function hasErrors($errors, $subfield = null)
    {
        return $errors->has($this->getDot($subfield));
    }
    
    public function getErrors($errors, $subfield = null)
    {
        return $errors->first($this->getDot($subfield));
    }
    
    protected function asDateTime($value)
    {
        if (empty($value)) {
            return null;
        }
        
        $array = json_decode($value, true);
        
        if (is_array($array) && isset($array['date'])) {
            
            $value = parent::asDateTime(trim($array['date'] . ' ' . @$array['time']));
            $timezone = isset($array['timezone']) ? $array['timezone'] : 'UTC';
            $value->setTimezone($timezone);
            
            return $value;
        }
        
        return parent::asDateTime($value);
    }
    
  
//     public function newPivot(Model $parent, array $attributes, $table, $exists)
//     {
      
//     }
  

}

/*
button
checkbox
color
date 
datetime 
datetime-local 
email 
file
hidden
image
month 
number 
password
radio
range 
reset
search
submit
tel
text
time 
url
week
*/
