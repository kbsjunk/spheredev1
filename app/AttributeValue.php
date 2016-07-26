<?php

namespace Sphere;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class AttributeValue extends MorphPivot
{
    protected $table = 'attribute_value';
  
    protected $casts = [
      'value' => 'json',
    ];
}
