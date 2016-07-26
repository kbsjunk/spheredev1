<div class="form-group{{ $field->hasErrors($errors, 'locality') ? ' has-error' : '' }}">
	<label for="{{ $field->getSlug('locality') }}" class="col-md-3 control-label">{{ trans('fields.address.'.$addressFormatter->getLocalityType($countryCode)) }}</label>
	<div class="col-md-9">

		@if($countryCode && $administrativeArea && $addressLocalities = $addressFormatter->getLocalities($countryCode, $administrativeArea))
		<input type="hidden" name="{{ $field->getName('localityList') }}" value="1">
		<select id="{{ $field->getSlug('locality') }}" name="{{ $field->getName('locality') }}" class="form-control">
			<option value=""></option>
			@foreach($addressLocalities as $option => $label)
			<option value="{{ $option }}" @if($option == $locality) selected @endif> {{ $label }} </option>
			@endforeach
		</select>
		@else
		<input type="text" class="form-control" id="{{ $field->getSlug('locality') }}" 
			placeholder="{{ trans('fields.address.'.$addressFormatter->getLocalityType($countryCode)) }}" 
			name="{{ $field->getName('locality') }}" value="{{ $locality }}">
		@endif

		@if ($field->hasErrors($errors, 'locality'))
		<span class="help-block">
			<strong>{{ $field->getError($errors, 'locality') }}</strong>
		</span>
		@elseif ($field->getHelp('locality'))
		<span class="help-block">
			{{ $field->getHelp('locality') }}
		</span>
		@endif
	</div>
</div>