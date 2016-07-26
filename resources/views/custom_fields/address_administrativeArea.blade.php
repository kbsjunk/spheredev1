<div class="form-group{{ $field->hasErrors($errors, 'administrativeArea') ? ' has-error' : '' }}">
	<label for="{{ $field->getSlug('administrativeArea') }}" class="col-md-3 control-label">{{ trans('fields.address.'.$addressFormatter->getAdministrativeAreaType($countryCode)) }}</label>
	<div class="col-md-9">
		
		@if($countryCode && $addressSubdivisions = $addressFormatter->getSubdivisions($countryCode))
		<input type="hidden" name="{{ $field->getName('administrativeAreaList') }}" value="1">
		<select id="{{ $field->getSlug('administrativeArea') }}" name="{{ $field->getName('administrativeArea') }}" class="form-control">
			<option value=""></option>
			@foreach($addressSubdivisions as $option => $label)
			<option value="{{ $option }}" @if($option == $administrativeArea) selected @endif> {{ $label }} </option>
			@endforeach
		</select>
		@else
		<input type="text" class="form-control" id="{{ $field->getSlug('administrativeArea') }}"
			placeholder="{{ trans('fields.address.'.$addressFormatter->getAdministrativeAreaType($countryCode)) }}"
			name="{{ $field->getName('administrativeArea') }}" value="{{ $administrativeArea }}">
		@endif

		@if ($field->hasErrors($errors, 'administrativeArea'))
		<span class="help-block">
			<strong>{{ $field->getError($errors, 'administrativeArea') }}</strong>
		</span>
		@elseif ($field->getHelp('administrativeArea'))
		<span class="help-block">
			{{ $field->getHelp('administrativeArea') }}
		</span>
		@endif
	</div>
</div>