<?php

namespace App\Http\Controllers;

use App\Models\Plainte;
use App\Support\PlainteStatut;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $plaintes = Plainte::with('service')
            ->where('id_user', $userId)
            ->latest()
            ->paginate(10);

        return view('users.index', [
            'plaintes' => $plaintes,
            'complaints' => $plaintes,
            'en_cours' => Plainte::where('id_user', $userId)->where('statut', PlainteStatut::EN_COURS)->count(),
            'resolues' => Plainte::where('id_user', $userId)->where('statut', PlainteStatut::RESOLUE)->count(),
            'en_attente' => Plainte::where('id_user', $userId)->where('statut', PlainteStatut::EN_ATTENTE)->count(),
        ]);
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'role' => ['required', 'exists:roles,id'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'id_role' => $request->role,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return redirect()->route('admin.users')->with('success', 'Utilisateur créé.');
    }

    public function settings()
    {
        return view('users.settings');
    }

    public function profile()
    {
        return view('users.profil');
    }

    public function updateProfile(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
        ]);

        auth()->user()->update($request->only('name', 'phone'));

        return back()->with('success', 'Profil mis à jour.');
    }

    public function updateEmail(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:users,email,' . auth()->id()],
        ]);

        auth()->user()->update(['email' => $request->email]);

        return back()->with('success', 'E-mail mis à jour.');
    }

    public function updatePassword(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = auth()->user();

        if (! \Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect.']);
        }

        $user->update(['password' => \Illuminate\Support\Facades\Hash::make($request->password)]);

        return back()->with('success', 'Mot de passe modifié.');
    }
}
