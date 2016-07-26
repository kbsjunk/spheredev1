<div class="form-group{{ $errors->has($field->getDot('countryCode')) ? ' has-error' : '' }}">
	<label for="{{ $field->getSlug('countryCode') }}" class="col-md-3 control-label">{{ trans('fields.address.countryCode') }}</label>
	<div class="col-md-9">

		<select id="{{ $field->getSlug('countryCode') }}" name="{{ $field->getName('countryCode') }}" class="form-control">
			<option value=""></option>
			@foreach($addressFormatter->getCountries() as $option => $label)
			<option value="{{ $option }}" @if($option == $countryCode) selected @endif> {{ $label }} </option>
			@endforeach
		</select>

		@if ($errors->has($field->getDot('countryCode')))
		<span class="help-block">
			<strong>{{ $errors->first($field->getDot('countryCode')) }}</strong>
		</span>
		@elseif ($field->getHelp('countryCode'))
		<span class="help-block">
			{{ $field->getHelp('countryCode') }}
		</span>
		@endif
	</div>
</div>