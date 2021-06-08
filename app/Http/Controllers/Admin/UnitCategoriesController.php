<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Models\UnitCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AppController;

class UnitCategoriesController extends AppController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $search = Request()->term;
        $categories = UnitCategory::search($search);
        return view('admin.unit_categories.index')->with('categories', $categories);
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function new()
    {
        $category = new UnitCategory();
        return view('admin.unit_categories.new', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\View\View | \Illuminate\Http\RedirectResponse.
     */
    public function create(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|unique:unit_categories,name'
        ]);

        $category = new UnitCategory($data);
        if ($validator->fails()) {
            $request->session()->flash('danger', 'Existem dados incorretos! Por favor verifique!');
            return view('admin.unit_categories.new', compact('category'))->withErrors($validator);
        }

        $category->save();
        return redirect()->route('admin.unit_categories')->with('success', 'Categoria cadastrada com sucesso');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UnitCategory  $name
     * @return  \Illuminate\View\View
     */
    public function edit($name)
    {
        $category = UnitCategory::find($name);
        return view('admin.unit_categories.edit', compact('category'));
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UnitCategory  $id
     * @return \Illuminate\View\View | \Illuminate\Http\RedirectResponse
     */

    public function update(Request $request, $id)
    {
        $category = UnitCategory::find($id);
        $data = array_filter($request->all());

        $validator = Validator::make($data, [
            'name' => "required|unique:unit_categories,name,{$category->id}"
        ]);

        $category->fill($data);
        if ($validator->fails()) {
            $request->session()->flash('danger', 'Existem dados incorretos! Por favor verifique!');
            return view('admin.unit_categories.edit', compact('category'))->withErrors($validator);
        }

        $category->save();
        return redirect()->route('admin.unit_categories')->with('success', 'Categoria atualizada com sucesso');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UnitCategory  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function destroy($id)
    {
        $category = UnitCategory::find($id);
        $category->delete();
        return redirect()->route('admin.unit_categories')->with('success', 'Categoria removida com sucesso.');
    }
}
