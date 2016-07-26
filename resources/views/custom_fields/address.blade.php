@inject('addressFormatter', 'formatter.address')

<?php
$countryCode = $field->getValue($entity, 'countryCode');
$administrativeArea = $field->getValue($entity, 'administrativeArea');
$locality = $field->getValue($entity, 'locality');
$dependentLocality = $field->getValue($entity, 'dependentLocality');
?>

<fieldset class="{{ $errors->has($field->slug) ? ' has-error' : '' }}" id="address_fields_{{ $field->slug }}" address-fields>
@include('custom_fields.address_countryCode')
@foreach($addressFormatter->getFields($countryCode) as $addressField)
@include('custom_fields.address_'.$addressField)
@endforeach
</fieldset>