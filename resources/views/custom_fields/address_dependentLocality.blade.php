<div class="form-group{{ $field->hasErrors($errors, 'dependentLocality') ? ' has-error' : '' }}">
	<label for="{{ $field->getSlug('dependentLocality') }}" class="col-md-3 control-label">{{ trans('fields.address.'.$addressFormatter->getDependentLocalityType($countryCode)) }}</label>
	<div class="col-md-9">

		@if($countryCode && $locality && $addressDependentLocalities = $addressFormatter->getLocalities($countryCode, $locality))
		<input type="hidden" name="{{ $field->getName('dependentLocalityList') }}" value="1">
		<select id="{{ $field->getSlug('dependentLocality') }}" name="{{ $field->getName('dependentLocality') }}" class="form-control">
			<option value=""></option>
			@foreach($addressDependentLocalities as $option => $label)
			<option value="{{ $option }}" @if($option == $dependentLocality) selected @endif> {{ $label }} </option>
			@endforeach
		</select>
		@else
		<input type="text" class="form-control" id="{{ $field->getSlug('dependentLocality') }}"
			placeholder="{{ trans('fields.address.'.$addressFormatter->getDependentLocalityType($countryCode)) }}" 
			name="{{ $field->getName('dependentLocality') }}" value="{{ $dependentLocality }}">
		@endif

		@if ($field->hasErrors($errors, 'dependentLocality'))
		<span class="help-block">
			<strong>{{ $field->getError($errors, 'dependentLocality') }}</strong>
		</span>
		@elseif ($field->getHelp('dependentLocality'))
		<span class="help-block">
			{{ $field->getHelp('dependentLocality') }}
		</span>
		@endif
	</div>
</div>