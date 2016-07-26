@inject('datetimeFormatter', 'formatter.datetime')

<?php
$timezones = $datetimeFormatter->getTimezones();
$date = $field->getValue($entity, 'datetime');
$timezone = $date ? $date->getTimezone()->getName() : 'UTC';
?>
<fieldset class="{{ $field->hasErrors($errors) ? ' has-error' : '' }}" id="datetime_fields_{{ $field->slug }}" datetime-fields="{{ $field->slug }}">
	
	<div class="form-group{{ $field->hasErrors($errors, 'date') ? ' has-error' : '' }}">
		<label for="{{ $field->getSlug('date') }}" class="col-md-3 control-label">{{ trans('fields.datetime.date') }}</label>
		<div class="col-md-6">
			<input type="date" class="form-control" id="{{ $field->getSlug() }}" name="{{ $field->getName() }}" value="{{ $date ? $date->format('Y-m-d') : null }}" datetime-date>
			@if ($field->hasErrors($errors, 'date'))
			<span class="help-block">
				<strong>{{ $field->getError($errors, 'date') }}</strong>
			</span>
			@elseif ($field->getHelp('date'))
			<span class="help-block">
				{{ $field->getHelp('date') }}
			</span>
			@endif
		</div>
	</div>

	<div class="form-group{{ $field->hasErrors($errors, 'time') ? ' has-error' : '' }}">
		<label for="{{ $field->getSlug('time') }}" class="col-md-3 control-label">{{ trans('fields.datetime.time') }}</label>
		<div class="col-md-6">
			<input type="time" class="form-control" id="{{ $field->getSlug() }}" name="{{ $field->getName() }}" value="{{ $date ? $date->format('H:i:s') : null }}" datetime-time>
			@if ($field->hasErrors($errors, 'time'))
			<span class="help-block">
				<strong>{{ $field->getError($errors, 'time') }}</strong>
			</span>
			@elseif ($field->getHelp('time'))
			<span class="help-block">
				{{ $field->getHelp('time') }}
			</span>
			@endif
		</div>
	</div>

	<div class="form-group{{ $field->hasErrors($errors, 'timezone') ? ' has-error' : '' }}">
		<label for="{{ $field->getSlug('timezone') }}" class="col-md-3 control-label">{{ trans('fields.datetime.timezone') }}</label>
		<div class="col-md-9">
			<select id="{{ $field->getSlug('timezone') }}" name="{{ $field->getName('timezone') }}" class="form-control" datetime-timezone>
				<option value=""></option>
				@foreach($timezones as $option => $label)
				<option value="{{ $option }}" @if($option == $timezone) selected @endif> {{ $label }} </option>
				@endforeach
			</select>

			@if ($field->hasErrors($errors, 'timezone'))
			<span class="help-block">
				<strong>{{ $field->getError($errors, 'timezone') }}</strong>
			</span>
			@elseif ($field->getHelp('timezone'))
			<span class="help-block">
				{{ $field->getHelp('timezone') }}
			</span>
			@endif
		</div>
	</div>
	
</fieldset>