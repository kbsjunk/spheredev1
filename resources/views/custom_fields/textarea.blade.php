<textarea class="form-control" id="{{ $field->getSlug() }}" placeholder="{{ $field->getLabel() }}" name="{{ $field->getName() }}">{{ $field->getValue($entity) }}</textarea>
