    @if ($errors->has($field->slug))
    <span class="help-block">
      <strong>{{ $errors->first($field->slug) }}</strong>
    </span>
    @elseif ($field->help)
    <span class="help-block">
      {{ $field->help }}
    </span>
    @endif
  </div>
</div>
