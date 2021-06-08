@extends('layouts.admin.app')

@section('title', 'Editar Perfil')

@section('content')

<form action="{{route('admin.profile.update')}}" method="post" enctype="multipart/form-data" novalidate>
	@method('PUT')
  @csrf

  @component('components.form.input_text',['field' => 'name',
 					   'label'    => 'Nome',
					   'model'    => 'user',
					   'value'    => $user->name,
                        'required' => true,
					   'errors'   => $errors]) @endcomponent

  <div class="form-row">
    <div class="col-sm-8">
      @component('components.form.input_email',['field'    => 'email',
						'label'    => 'Email',
						'model'    => 'user',
						'value'    => $user->email,
						'required' => true,
						'errors'   => $errors]) @endcomponent


      @component('components.form.input_password',['field'    => 'current_password',
  						   'label'    => 'Senha Atual',
						   'hint'     => 'precisamos da sua senha atual para confirmar suas mudanças',
						   'model'    => 'user',
						   'required' => true,
						   'errors'   => $errors]) @endcomponent
    </div>

    <div class="col-sm-4">
      @component('components.form.input_image_preview',['field'      => 'image',
							'label'      => 'Clique na imagem para alterá-la',
							'image_path' => $user->image_path,
							'model'      => 'user']) @endcomponent
    </div>
  </div>

  @component('components.form.input_submit', ['value' => 'Atualizar', 'back_url' => route('admin.dashboard')]) @endcomponent
</form>
@endsection
