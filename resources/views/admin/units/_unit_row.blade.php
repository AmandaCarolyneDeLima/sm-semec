<tr>
  <td><a href="{{route('admin.show.unit', $unit->id)}}">{{ $unit->name }}</a></td>
  <td>{{ $unit->address }}</td>
  <td>{{ $unit->phone }}</td>
  <td>{{ $unit->category->name }}</td>
  <td>
    @component('components.links.edit', ['url' => route('admin.edit.unit', $unit->id)]) @endcomponent
    @component('components.links.delete', ['url' => route('admin.destroy.unit', $unit->id)]) @endcomponent
  </td>
</tr>
