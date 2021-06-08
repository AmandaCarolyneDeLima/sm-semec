<form action="{{ $route }}" method="POST" enctype="multipart/form-data" autocomplete="off" novalidate>
    @csrf
    @method($method)
    @component('components.form.input_text', ['field'    => 'name',
                                              'label'    => 'Nome',
                                              'model'    => 'user',
                                              'value'    => $user->name,
                                              'required' => true,
                                              'errors'   => $errors]) @endcomponent

    @component('components.form.input_email', ['field'    => 'email',
                                               'label'    => 'Email',
                                               'model'    => 'user',
                                               'value'    => $user->email,
                                               'required' => true,
                                               'errors'   => $errors]) @endcomponent

    @component('components.form.input_text', ['field'    => 'CPF',
                                              'label'    => 'CPF',
                                              'model'    => 'user',
                                              'value'    => $user->CPF,
                                              'required' => true,
                                              'errors'   => $errors]) @endcomponent

    @component('components.form.input_password', ['field'    => 'password',
                                                  'label'    => 'Senha',
                                                  'model'    => 'user',
                                                  'required' => true,
                                                  'errors'   => $errors]) @endcomponent

    @component('components.form.input_submit',['value' => $submit, 'back_url' => route('admin.users')]) @endcomponent
</form>
