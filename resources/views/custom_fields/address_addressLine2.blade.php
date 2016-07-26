<div class="form-group{{ $errors->has($field->getDot('addressLine2')) ? ' has-error' : '' }}">
	<label for="{{ $field->getSlug('addressLine2') }}" class="col-md-3 control-label">{{ trans('fields.address.addressLine2') }}</label>
	<div class="col-md-9">

		<input type="text" class="form-control" id="{{ $field->getSlug('addressLine2') }}" placeholder="{{ trans('fields.address.addressLine2') }}" 
		name="{{ $field->getName('addressLine2') }}" value="{{ old($field->getDot('addressLine2'), $entity->getCustomValue($field->getDot('addressLine2'))) }}">

		@if ($errors->has($field->getDot('addressLine2')))
		<span class="help-block">
			<strong>{{ $errors->first($field->getDot('addressLine2')) }}</strong>
		</span>
		@elseif ($field->getHelp('addressLine2'))
		<span class="help-block">
			{{ $field->getHelp('addressLine2') }}
		</span>
		@endif
	</div>
</div>