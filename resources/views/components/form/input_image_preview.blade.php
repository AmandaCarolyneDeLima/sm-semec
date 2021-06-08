<div id="box-image-preview" data-toggle="tooltip" data-placement="left" title="{{ $label }}">
	<div class="input-field image_preview">
		<div class="box-image center">

			<img src="{{ $image_path }}" class="file_preview active" id="image">

			<div class="form-group file optional user_profile_image form-group-valid">
				<input id="{{ $model}}_{{ $field }}" accept="image/*" type="file" name="{{ $field }}" class="form-control-file is-valid file optional image_validate">
			</div>
		</div>
	</div>
	<div class="text-box text-center">
		<p class="text-input"> {{ $label }}</p>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="image_preview_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
			<div class="modal-body pb-0">
        <div class="alert alert-icon alert-danger" role="alert">
        	<i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i> O tamanho da imagem não deve ser superior a 5M.
        </div>
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
