<tr>
  <td><a href="{{route('servant.show.edict', $edict->id)}}">{{ $edict->title }}</a></td>
  <td>{{ $edict->started_at->toShortDateTime() }}</td>
  <td>{{ $edict->ended_at->toShortDateTime() }}  </td>
  <td>
  	@isset($route)
    <a class="btn btn-primary" href="{{ $route }}">Inscreva-se</a>
   </td>
   @endisset
</tr>
