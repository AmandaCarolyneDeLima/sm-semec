<tr>
	<td><a href="{{route('admin.show.pdf', ['edict_id' => $pdfs->edict->id, 'id' => $pdfs->id])}}">{{ $pdfs->name }}</a></td>
	<td>{{ $pdfs->edict->title }}</td>
	<td>{{ $pdfs->created_at->toShortDateTime() }}</td>
	<td>{{ $pdfs->updated_at->toShortDateTime() }}</td>
	<td> @component('components.links.delete', ['url' => route('admin.destroy.pdf', $pdfs->id)]) @endcomponent</td>
</tr>
