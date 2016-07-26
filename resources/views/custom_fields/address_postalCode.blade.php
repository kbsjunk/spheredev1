<div class="form-group{{ $errors->has($field->getDot('postalCode')) ? ' has-error' : '' }}">
	<label for="{{ $field->getSlug('postalCode') }}" class="col-md-3 control-label">{{ trans('fields.address.'.$addressFormatter->getPostalCodeType($countryCode)) }}</label>
	<div class="col-md-6">

		<input type="text" class="form-control" id="{{ $field->getSlug('postalCode') }}" placeholder="{{ trans('fields.address.'.$addressFormatter->getPostalCodeType($countryCode)) }}" 
		name="{{ $field->getName('postalCode') }}" value="{{ old($field->getDot('postalCode'), $entity->getCustomValue($field->getDot('postalCode'))) }}">

		@if ($errors->has($field->getDot('postalCode')))
		<span class="help-block">
			<strong>{{ $errors->first($field->getDot('postalCode')) }}</strong>
		</span>
		@elseif ($field->getHelp('postalCode'))
		<span class="help-block">
			{{ $field->getHelp('postalCode') }}
		</span>
		@endif
	</div>
</div>