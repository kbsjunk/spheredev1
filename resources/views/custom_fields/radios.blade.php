@if($field->getSetting('cols'))
<div class="row" @if($field->getSetting('height')) style="max-height: {{ $field->getSetting('height') }}px; overflow-y: auto;" @endif> 
	@foreach(array_chunk($field->options, $field->getChunks(), true) as $chunk)
	<div class="col-md-{{ 12 / (int) $field->getSetting('cols') }}">
		@foreach($chunk as $option => $label)
		<div class="radio">
			<label>
				<input type="radio" id="{{ $field->getSlug($option) }}" name="{{ $field->getName() }}" value="{{ $option }}" @if($option == $field->getValue($entity)) checked @endif> {{ $label }}
			</label>
		</div>
		@endforeach
	</div>
	@endforeach
</div>
@else
@foreach($field->options as $option => $label)
<div class="radio">
  <label>
    <input type="radio" id="{{ $field->getSlug($option) }}_{{ $option }}" name="{{ $field->getName() }}" value="{{ $option }}" @if($option == $field->getValue($entity)) checked @endif> {{ $label }}
  </label>
</div>
@endforeach
@endif