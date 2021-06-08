<tr>
  <td><a href="{{route('admin.show.user', $user->id)}}">{{ $user->name }}</a></td>
  <td>{{ $user->email }}</td>
  <td>{{ $user->created_at->toShortDateTime() }}</td>
  <td >
    @component('components.links.edit', ['url' => route('admin.edit.user', $user->id)]) @endcomponent
    @component('components.links.delete', ['url' => route('admin.destroy.user', $user->id)]) @endcomponent
  </td>
</tr>
