<div class="form-group email @if ($required) required @endif {{ $model }}_{{ $field }}">

	<label class="form-control-label email required" for="name">
		{{ $label}} @if ($required) <abbr title="obrigatório">*</abbr> @endif
	</label>

	<input class="form-control email @if ($required) required @endif @if ($errors->has($field)) is-invalid @endif"
				 @if ($required) required="required" @endif
				 autofocus="autofocus" type="email" name="{{ $field }}"
	  		 value="{{ $value ?? '' }}" id="{{ $model }}_{{ $field }}"/>

	@if ($errors->has($field))
		<span class="invalid-feedback" role="alert">
			@foreach ($errors->get($field) as $message)
				<strong>{{ $message }}</strong>
			@endforeach
		</span>
	@endif

	<small class="form-text text-muted">{{ $hint ?? ''}}</small>
</div>
