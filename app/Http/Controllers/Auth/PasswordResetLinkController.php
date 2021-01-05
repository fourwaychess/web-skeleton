<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View Returns the response.
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request.
     *
     * @return \Illuminate\Http\RedirectResponse Returns the response.
     *
     * @throws \Illuminate\Validation\ValidationException If the validation fails.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
}