<div class="form-group">
	<div class="custom-file">
		<input id="{{ $model}}_{{ $field }}" type="file" accept="pdf/*" class="custom-file-input @if ($required) required @endif @if ($errors->has($field)) is-invalid @endif"  @if ($required) required="required" @endif name="{{ $field }}">
		<label class="custom-file-label">Escolher Arquivo</label>

		@if ($errors->has($field))
		<span class="invalid-feedback" role="alert">
			@foreach ($errors->get($field) as $message)
			<strong>{{ $message }}</strong>
			@endforeach
		</span>
		@endif
		<small class="form-text text-muted">{{ $hint ?? ''}}</small>
	</div>
</div>