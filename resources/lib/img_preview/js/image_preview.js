$(document).ready(() => {
  const input = $('.image_preview input[type=file]');
  SMSemec.imagePreview(input);
});

SMSemec.imagePreview = (el) => {
  const readURL = (input) => {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = (e) => {
        if(input.files[0].size > 5242880) {
          $('#image_preview_modal').modal();
          input.value = '';
        } else {
          $('.file_preview').attr('src', e.target.result);
          return $('.file_preview').addClass('active');
        }
      };

      return reader.readAsDataURL(input.files[0]);
    }
  };

  return $(el).change(function preview() {
    readURL(this);
  });
};
