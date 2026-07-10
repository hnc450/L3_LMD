<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // ou ton modèle Admin si tu utilises une table différente

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

    // 🔑 Connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/users')->with('success','Connexion réussie');
        }

        return back()->withErrors([
            'email' => 'Les identifiants sont incorrects.',
        ])->onlyInput('email');
    }

    // 🆕 Inscription
    public function sign(Request $request)
    {
        $request->validate([
            'name' => ['required','min:3','max:255'],
            'prenom' => ['required','min:3','max:255'],
            'email' => ['required','email','min:9','max:255'],
            'password' => ['required','min:8','max:16'],
            'phone' => ['required','min:9','max:16','regex:/^(?:\+243|0)\d{8,9}$/'],
            'password_confirmation' => ['required','same:password']
        ]);

        $user = User::create([
            'name' => $request->name . ' ' . $request->prenom,
            'email'=> $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'id_role' => 1, // Assurez-vous que le rôle "citoyen" a l'ID 2 dans votre table des rôles
        ]);

        Auth::login($user);

        return redirect('/dashboard')->with('success','Compte créé avec succès');
    }

    // 🔄 Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success','Déconnecté avec succès');
    }

    // 🔧 Formulaire reset password
    public function showResetForm()
    {
        return view('password.reset');
    }
    
}