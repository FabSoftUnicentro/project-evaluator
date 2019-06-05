<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        return view('password.edit');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|string',
            'new_password' => 'required|string|confirmed'
        ]);

        /** @var User $user */
        $user = $request->user();

        if (! Hash::check($request->get('old_password'), $user->password)) {
            return redirect()->back()->with([
                'alert-danger' => 'Senha atual incorreta!'
            ]);
        }

        $user->password = Hash::make($request->get('new_password'));
        try {
            $user->save();

            Auth::setUser($user);

            return redirect()->route('passwords.edit')->with([
                'alert-success' => 'Senha alterada com sucesso!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'alert-danger' => 'Falha ao alterar senha!'
            ]);
        }
    }
}
