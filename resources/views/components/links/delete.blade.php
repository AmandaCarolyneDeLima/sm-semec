<form action="{{ $url }}" method="POST" class="float-right" onSubmit="return confirm('Tem certeza?')">
	@csrf
	@method('DELETE')
	<button type="submit" class="btn-link p-0 ml-1"><i class="far fa-trash-alt"></i></button>
</form>
