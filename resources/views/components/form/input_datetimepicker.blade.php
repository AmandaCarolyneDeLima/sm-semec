<div class="form-group string @if ($required) required @endif {{ $model }}_{{ $field }}">

	<label class="form-control-label string required" for="name">
		{{ $label}} @if ($required) <abbr title="obrigatório">*</abbr> @endif
	</label>

        <div class="input-group date datetimepicker-load" id="{{ $model }}_{{ $field }}" data-target-input="nearest">
          <input type="text" class="form-control datetimepicker-input @if ($errors->has($field)) is-invalid @endif"
		 name="{{ $field }}" data-target="#{{ $model }}_{{ $field }}"
		  value="{{ optional($value)->toShortDateTime() }}"
		 @if ($required) required="required" @endif />
           <div class="input-group-append" data-target="#{{ $model }}_{{ $field }}" data-toggle="datetimepicker">
	      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
  	   </div>
        </div>

	@if ($errors->has($field))
		<span class="invalid-feedback d-block" role="alert">
			@foreach ($errors->get($field) as $message)
				<strong>{{ $message }}</strong>
			@endforeach
		</span>
	@endif

	<small class="form-text text-muted">{{ $hint ?? ''}}</small>
</div>
