<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    public function showResetForm()
    {
        return view('Auth.password-reset');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $user->sendPasswordResetNotification($token);
        }

        return back()->with('message', 'Un email de réinitialisation de mot de passe vous a été envoyé.');
    }

    public function showResetPasswordForm($token)
    {
        return view('Auth.password-reset', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->passwordReset->token == $request->token) {
            $user->update([
                'password' => $request->password,
            ]);

            return redirect()->route('login')->with('message', 'Votre mot de passe a été réinitialisé avec succès.');
        }

        return back()->withErrors([
            'email' => "L'email ou le token est incorrect."
        ]);
    }

    
}

