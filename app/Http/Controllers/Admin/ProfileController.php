<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Admin\AppController;
use App\Rules\ConfirmCurrentPassword;
use App\Models\User;

class ProfileController extends AppController
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\View\View
     */

    public function edit()
    {
        $user = \Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\View\View.
         */
    public function update(Request $request)
    {
        $user = User::find(\Auth::user()->id);
        $data = $request->all();

        $validator = Validator::make($data, [
            'current_password' => new ConfirmCurrentPassword($user->password),
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user->fill($data);
        if ($validator->fails()) {
            $request->session()->flash('danger', 'Existem dados incorretos! Por favor verifique!');
            return view('admin.profile.edit', compact('user'))->withErrors($validator);
        }

        $user->save();
        return redirect()->route('admin.profile.edit')->with('success', 'Perfil atualizado com sucesso');
    }

    /**
     * Show the form for editing the specified resource.
     *
   * @return \Illuminate\View\View
     */
    public function editPassword()
    {
        return view('admin.profile.edit_password');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\RedirectResponse.
     */

    public function updatePassword(Request $request)
    {
        $user = User::find(\Auth::user()->id);

        $this->validate($request, [
            'current_password' => new ConfirmCurrentPassword($user->password),
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);

        $user->password = $request->input('password');
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Senha alterada com sucesso');
    }
}
