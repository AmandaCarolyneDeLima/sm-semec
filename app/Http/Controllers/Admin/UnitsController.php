<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Models\Unit;
use App\Models\UnitCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AppController;

class UnitsController extends AppController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $search = Request()->term;
        $units = Unit::search($search);
        return view('admin.units.index')->with('units', $units);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function new()
    {
        $unit = new Unit();
        $categories = UnitCategory::all();
        return view('admin.units.new', compact('unit', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\View\View | \Illuminate\Http\RedirectResponse.
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $categories = UnitCategory::all();

        $validator = Validator::make($data, [
            'name' => 'required|unique:units,name',
            'address' => 'required',
            'phone' => 'required|min:10|unique:units,phone',
            'category_id' => 'required',
        ]);

        $unit = new Unit($data);
        if ($validator->fails()) {
            $request->session()->flash('danger', 'Existem dados incorretos! Por favor verifique!');
            return view('admin.units.new', compact('unit', 'categories'))->withErrors($validator);
        }

        $unit->save();
        return redirect()->route('admin.units')->with('success', 'Unidade cadastrada com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $unit =  Unit::find($id);
        return view('admin.units.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $id
     * @return  \Illuminate\View\View
     */
    public function edit($id)
    {
        $unit = Unit::find($id);
        $categories = UnitCategory::all();
        return view('admin.units.edit', compact('unit', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $id
     * @return \Illuminate\View\View | \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $unit = Unit::find($id);
        $categories = UnitCategory::all();
        $data = array_filter($request->all());

        $validator = Validator::make($data, [
            'name' => "required|unique:units,name,$id",
            'address' => 'required',
            'phone' => "required|min:10|unique:units,phone,$id",
            'category_id' => 'required',
        ]);

        $unit->fill($data);
        if ($validator->fails()) {
            $request->session()->flash('danger', 'Existem dados incorretos! Por favor verifique!');
            return view('admin.units.edit', compact('unit', 'categories'))->withErrors($validator);
        }

        $unit->save();
        return redirect()->route('admin.units')->with('success', 'Unidade atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function destroy($id)
    {
        $unit = Unit::find($id);
        $unit->delete();
        return redirect()->route('admin.units')->with('success', 'Unidade removida com sucesso.');
    }
}
