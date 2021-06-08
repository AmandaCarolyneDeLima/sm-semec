<div class="form-group string @if ($required) required @endif {{ $model }}_{{ $field }}">

	<label class="form-control-label string required" for="name">
		{{ $label}} @if ($required) <abbr title="obrigatório">*</abbr> @endif
	</label>

	<textarea class="form-control @if ($required) required @endif @if ($errors->has($field)) is-invalid @endif"
				 @if ($required) required="required" @endif
				 autofocus="autofocus" name="{{ $field }}" rows="4"
				 id="{{ $model }}_{{ $field }}">{{ $value ?? '' }}</textarea>

	@if ($errors->has($field))
		<span class="invalid-feedback" role="alert">
			@foreach ($errors->get($field) as $message)
				<strong>{{ $message }}</strong>
			@endforeach
		</span>
	@endif

	<small class="form-text text-muted">{{ $hint ?? ''}}</small>
</div>
