<div class="form-group{{ $errors->has($field->getDot('addressLine1')) ? ' has-error' : '' }}">
	<label for="{{ $field->getSlug('addressLine1') }}" class="col-md-3 control-label">{{ trans('fields.address.addressLine1') }}</label>
	<div class="col-md-9">

		<input type="text" class="form-control" id="{{ $field->getSlug('addressLine1') }}" placeholder="{{ trans('fields.address.addressLine1') }}" 
		name="{{ $field->getName('addressLine1') }}" value="{{ old($field->getDot('addressLine1'), $entity->getCustomValue($field->getDot('addressLine1'))) }}">

		@if ($errors->has($field->getDot('addressLine1')))
		<span class="help-block">
			<strong>{{ $errors->first($field->getDot('addressLine1')) }}</strong>
		</span>
		@elseif ($field->getHelp('addressLine1'))
		<span class="help-block">
			{{ $field->getHelp('addressLine1') }}
		</span>
		@endif
	</div>
</div>