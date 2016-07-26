<div class="form-group{{ $errors->has($field->getDot('sortingCode')) ? ' has-error' : '' }}">
	<label for="{{ $field->getSlug('sortingCode') }}" class="col-md-3 control-label">{{ trans('fields.address.sortingCode') }}</label>
	<div class="col-md-6">

		<input type="text" class="form-control" id="{{ $field->getSlug('sortingCode') }}" placeholder="{{ trans('fields.address.sortingCode') }}" 
		name="{{ $field->getName('sortingCode') }}" value="{{ old($field->getDot('sortingCode'), $entity->getCustomValue($field->getDot('sortingCode'))) }}">

		@if ($errors->has($field->getDot('sortingCode')))
		<span class="help-block">
			<strong>{{ $errors->first($field->getDot('sortingCode')) }}</strong>
		</span>
		@elseif ($field->getHelp('sortingCode'))
		<span class="help-block">
			{{ $field->getHelp('sortingCode') }}
		</span>
		@endif
	</div>
</div>