$('.custom-file-input').change((e) => {
	const el = e.currentTarget;
	$(el).siblings('.custom-file-label').text(el.files[0].name);
});