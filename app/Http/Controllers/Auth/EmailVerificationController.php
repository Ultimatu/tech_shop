<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify(Request $request)
    {
        if ($request->route('id') == $request->user()->getKey() &&
            $request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->route('home');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }


    public function show()
    {
        return view('Auth.email-verification');
    }

}
