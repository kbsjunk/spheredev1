<?php
$date = $field->getValue($entity);
?>
<input type="date" class="form-control" id="{{ $field->getSlug() }}" placeholder="{{ $field->getLabel() }}" name="{{ $field->getName() }}" value="{{ $date ? $date->format('Y-m-d') : null }}">