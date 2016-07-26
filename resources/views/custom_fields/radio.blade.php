<div class="radio">
  <label>
    <input type="radio" id="{{ $field->getSlug() }}_Y" name="{{ $field->getName() }}" value="1" @if(true == $field->getValue($entity)) checked @endif> {{ $field->getOption(1) ?: trans('fields.boolean.true') }}
  </label>
</div>
<div class="radio">
  <label>
    <input type="radio" id="{{ $field->getSlug() }}_N" name="{{ $field->getName() }}" value="0" @if(false == $field->getValue($entity)) checked @endif> {{ $field->getOption(0) ?: trans('fields.boolean.false') }}
  </label>
</div>