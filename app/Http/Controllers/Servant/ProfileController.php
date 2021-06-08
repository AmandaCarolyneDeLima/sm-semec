<?php

namespace App\Http\Controllers\Servant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Servant\AppController;
use Illuminate\Http\Request;
use App\Models\Servant;
use App\Rules\ConfirmCurrentPassword;
use Illuminate\Support\Facades\Validator;

class ProfileController extends AppController
{
    /**
    * Show the form for editing the specified resource.
    *
    * @return \Illuminate\View\View
    */
    public function edit()
    {
        $servant = \Auth::guard('servant')->user();
        return view('servant.profile.edit', compact('servant'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return  \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    */
    public function update(Request $request)
    {
        $servant = Servant::find(\Auth::guard('servant')->user()->id);
        $data = $request->all();

        $validator = Validator::make($data, [
            'current_password' => new ConfirmCurrentPassword($servant->password),
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $servant->fill($data);
        if ($validator->fails()) {
            $request->session()->flash('danger', 'Existem dados incorretos! Por favor verifique!');
            return view('servant.profile.edit', compact('servant'))->withErrors($validator);
        }

        $servant->save();
        return redirect()->route('servant.profile.edit')->with('success', 'Perfil atualizado com sucesso');
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @return \Illuminate\View\View
    */
    public function editPassword()
    {
        return view('servant.profile.edit_password');
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return  \Illuminate\Http\RedirectResponse.
    */
    public function updatePassword(Request $request)
    {
        $servant = Servant::find(\Auth::guard('servant')->user()->id);
        $this->validate($request, [
            'current_password' => new ConfirmCurrentPassword($servant->password),
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);
        $servant->password = $request->input('password');
        $servant->save();

        return redirect()->route('servant.dashboard')->with('success', 'Senha alterada com sucesso');
    }
}
