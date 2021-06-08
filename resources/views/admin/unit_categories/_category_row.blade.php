<tr>
  <td>{{ $category->name }}</td>
  <td >
    @component('components.links.edit', ['url' => route('admin.edit.unit_category', $category->id)]) @endcomponent
    @component('components.links.delete', ['url' => route('admin.destroy.unit_category', $category->id)]) @endcomponent
  </td>
</tr>
