<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Admin\AppController;
use App\Services\DateFormatter;

class UsersController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     *  @return \Illuminate\View\View
     *  @param  string $search
     */
    public function index($search = null)
    {
        $users = User::search($search);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function new()
    {
        $user = new User();
        return view('admin.users.new', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\View\View | \Illuminate\Http\RedirectResponse.
       */
    public function create(Request $request)
    {
        $data = $request->all();
        $user = new User($data);

        $validator = Validator::make($data, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $request->session()->flash('danger', 'Existem dados incorretos! Por favor verifique!');
            return view('admin.users.new', compact('user'))->withErrors($validator);
        }

        $user->save();
        return redirect()->route('admin.users')->with('success', 'Usuário cadastrado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $id
     * @return  \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $id
     * @return \Illuminate\View\View | \Illuminate\Http\RedirectResponse
     */

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $data = array_filter($request->all());

        $validator = Validator::make($data, [
            'name'     => 'required',
            'email'    => "required|email|unique:users,email,{$user->id},id",
            'password' => 'string|min:6',
        ]);

        $user->fill($data);
        if ($validator->fails()) {
            $request->session()->flash('danger', 'Existem dados incorretos! Por favor verifique!');
            return view('admin.users.edit', compact('user'))->withErrors($validator);
        }

        $user->save();
        return redirect()->route('admin.users')->with('success', 'Usuário atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Usuário removido com sucesso.');
    }
}
