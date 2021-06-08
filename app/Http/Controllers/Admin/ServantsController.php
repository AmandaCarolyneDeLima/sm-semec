<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AppController;
use App\Models\Servant;

class ServantsController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $search = Request()->term;
        $servants = Servant::search($search);
        return view('admin.servants.index')->with('servants', $servants);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $servant = Servant::with(['contracts', 'dependents', 'contracts.acts', 'licenses.contract'])->find($id);
        return view('admin.servants.show', compact('servant'));
    }
}
