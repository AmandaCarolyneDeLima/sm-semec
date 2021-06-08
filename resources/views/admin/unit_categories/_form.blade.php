<form action="{{ $route }}" method="POST" novalidate>
    @csrf
    @method($method)
    @component('components.form.input_text', ['field'    => 'name',
                                              'label'    => 'Nome da Categoria',
                                              'model'    => 'unit_category',
                                              'value'    => $category->name,
                                              'required' => true,
                                              'errors'   => $errors]) @endcomponent

    @component('components.form.input_submit',['value' => $submit, 'back_url' => route('admin.unit_categories')]) @endcomponent
</form>
