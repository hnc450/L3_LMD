<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            ActivityLogger::log('login', 'Connexion réussie');

            return redirect()->intended(route(Auth::user()->dashboardRoute()))
                ->with('success', 'Connexion réussie');
        }

        return back()->withErrors([
            'email' => 'Les identifiants sont incorrects.',
        ])->onlyInput('email');
    }

    public function sign(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'prenom' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'phone' => ['required', 'regex:/^(?:\+243|0)\d{8,9}$/'],
        ]);

        $user = User::create([
            'name' => $request->name . ' ' . $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'id_role' => 1,
        ]);

        Auth::login($user);
        ActivityLogger::log('create', 'Inscription citoyen', $user->id);

        // Send email verification
        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice')
            ->with('success', 'Compte créé avec succès. Veuillez vérifier votre email.');
    }

    public function logout(Request $request)
    {
        ActivityLogger::log('login', 'Déconnexion');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login')
            ->with('success', 'Déconnecté avec succès');
    }

    public function showResetForm()
    {
        return view('password.reset');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Un lien de réinitialisation a été envoyé à votre adresse e-mail.')
            : back()->withErrors(['email' => 'Aucun compte associé à cette adresse.']);
    }

    public function showVerificationNotice()
    {
        return view('auth.verify');
    }

    public function verifyEmail(Request $request)
    {
        $user = User::find($request->route('id'));

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return redirect()->route('verification.notice')->with('error', 'Lien de vérification invalide.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route(auth()->user()->dashboardRoute())->with('success', 'Email déjà vérifié.');
        }

        if ($user->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($user));
        }

        return redirect()->route(auth()->user()->dashboardRoute())->with('success', 'Email vérifié avec succès.');
    }

    public function resendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }

    public function showResetFormWithToken(Request $request, $token)
    {
        return view('password.reset-with-token', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new \Illuminate\Auth\Events\PasswordReset($user));
        });

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('auth.login')->with('success', 'Mot de passe réinitialisé avec succès.')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
