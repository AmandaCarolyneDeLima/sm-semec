<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Models\Edict;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AppController;

class EdictsController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $search = Request()->term;
        $edicts = Edict::search($search);
        return view('admin.edicts.index')->with('edicts', $edicts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function new()
    {
        $edict = new Edict();
        return view('admin.edicts.new', compact('edict'));
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
            'title'       => 'required',
            'description' => 'required',
            'started_at'  => 'required|date_format:d/m/Y H:i',
            'ended_at'    => 'required|date_format:d/m/Y H:i|after_or_equal:started_at'
        ]);

        $this->filterDateTimeFormat($data, ['started_at', 'ended_at']);
        $edict = new Edict($data);
        if ($validator->fails()) {
            $request->session()->flash('danger', 'Existem dados incorretos! Por favor verifique!');
            return view('admin.edicts.new', compact('edict'))->withErrors($validator);
        }

        $edict->save();
        return redirect()->route('admin.edicts')->with('success', 'Edital cadastrado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Edict  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $edict =  Edict::find($id);
        return view('admin.edicts.show', compact('edict'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Edict  $id
     * @return  \Illuminate\View\View
     */
    public function edit($id)
    {
        $edict = Edict::find($id);
        return view('admin.edicts.edit', compact('edict'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Edict  $id
     * @return \Illuminate\View\View | \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $edict = Edict::find($id);
        $data = array_filter($request->all());

        $validator = Validator::make($data, [
            'title'       => 'required',
            'description' => 'required',
            'started_at'  => 'required|date_format:d/m/Y H:i',
            'ended_at'    => 'required|date_format:d/m/Y H:i|after_or_equal:started_at'
        ]);

        $this->filterDateTimeFormat($data, ['started_at', 'ended_at']);
        $edict->fill($data);
        if ($validator->fails()) {
            $request->session()->flash('danger', 'Existem dados incorretos! Por favor verifique!');
            return view('admin.edicts.edit', compact('edict'))->withErrors($validator);
        }

        $edict->save();
        return redirect()->route('admin.edicts')->with('success', 'Edital atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Edict  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function destroy($id)
    {
        $edict = Edict::find($id);
        $edict->delete();
        return redirect()->route('admin.edicts')->with('success', 'Edital removido com sucesso.');
    }
}
