<select id="{{ $field->getSlug() }}" name="{{ $field->getName() }}" class="form-control">
@foreach($field->options as $option => $label)
  <option value="{{ $option }}" @if($option == $field->getValue($entity)) selected @endif> {{ $label }} </option>
@endforeach
</select>