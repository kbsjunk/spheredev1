<div class="checkbox">
  <label>
    <input type="hidden" name="{{ $field->getName() }}" value="0">
    <input type="checkbox" id="{{ $field->getSlug() }}" name="{{ $field->getName() }}" value="1" @if($field->getValue($entity)) checked @endif> {{ $field->getOption(1) }}
  </label>
</div>