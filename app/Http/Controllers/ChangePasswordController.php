<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Ubah Password';
        $token = $request->route()->parameter('token');
        return view('auth.passwords.change', compact('token','title'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'old_password' => 'required',
            'new_password' => ['required', Password::min(8)->letters()
                ->mixedCase()
                ->numbers()],
            'password_confirmation' => 'same:new_password'
        ]);
        $user = auth()->user();
        if(Hash::check($request->old_password, $user->password)){
            $user->password = bcrypt($validatedData['new_password']);
            $user->update();
            Auth::logout();
            return redirect()->route('login')->with('success', 'Silahkan login kembali');
        }else{
            return redirect()->back()->with('failed', 'Old password does not matched');
        };
    }
}
