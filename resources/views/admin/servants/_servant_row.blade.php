<tr>
  <td>
    <a href="{{route('admin.show.servant', $servant->id)}}">{{ $servant->name }}</a>
  </td>
  <td>{{ $servant->CPF }}</td>
  <td>{{ $servant->lastContract()->registration }}</td>
  <td>{{ $servant->lastContract()->role }}</td>
  <td>{{ $servant->lastContract()->place }}</td>
  </td>
</tr>
