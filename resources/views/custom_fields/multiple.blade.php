<select id="{{ $field->getSlug() }}" name="{{ $field->getSlug() }}[]" class="form-control" multiple>
@foreach($field->options as $option => $label)
  <option value="{{ $option }}" @if(in_array($option, $field->getValue($entity), true)) selected @endif>{{ $label }}</option>
@endforeach
</select>