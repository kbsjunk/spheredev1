@inject('telephoneFormatter', 'formatter.telephone')
<?php
$countryCode = old($field->getDot('countryCode'), $entity->getCustomValue($field->getDot('countryCode')));
?>
<div class="row">
	<div class="col-sm-2 col-xs-3" style="padding-right:0;">
		<select id="{{ $field->getSlug('countryCode') }}" name="{{ $field->getName('countryCode') }}" class="form-control">
			<option value=""></option>
			@foreach($telephoneFormatter->getCountries() as $option => $label)
			<option value="{{ $option }}" @if($option == $countryCode) selected @endif> {{ $label }} </option>
			@endforeach
		</select>
	</div>
	<div class="col-md-6 col-sm-7 col-xs-9">
		<input type="tel" class="form-control" id="{{ $field->getSlug('telephoneNumber') }}"
			placeholder="{{ $field->label }}" name="{{ $field->getSlug('telephoneNumber') }}"
			value="{{ $telephoneFormatter->format($countryCode, $field->getValue($entity, 'telephoneNumber')) }}">
	</div>
</div>