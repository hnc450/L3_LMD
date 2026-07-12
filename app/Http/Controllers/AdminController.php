<?php

namespace App\Http\Controllers;

use App\Models\Plainte;
use App\Models\Service;
use App\Models\User;
use App\Services\ActivityLogger;
use App\Support\PlainteStatut;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Plainte::with(['service', 'user', 'agent'])->latest();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('service')) {
            $query->where('id_service', $request->service);
        }

        if ($request->filled('priorite')) {
            $query->where('priorite', $request->priorite);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('code_suivi', 'like', "%{$search}%");
            });
        }

        $complaints = $query->paginate(15)->withQueryString();

        return view('admins.index', [
            'complaints' => $complaints,
            'statuts' => PlainteStatut::all(),
            'total' => Plainte::count(),
            'en_attente' => Plainte::where('statut', PlainteStatut::EN_ATTENTE)->count(),
            'en_cours' => Plainte::where('statut', PlainteStatut::EN_COURS)->count(),
            'resolues' => Plainte::where('statut', PlainteStatut::RESOLUE)->count(),
            'services' => Service::all(),
        ]);
    }

    public function users()
    {
        $users = User::with('role')->paginate(10);

        return view('admins.users', [
            'users' => $users,
            'userCount' => User::count(),
            'adminCount' => User::whereHas('role', fn ($q) => $q->where('name', 'admin'))->count(),
            'responsablesCount' => User::whereHas('role', fn ($q) => $q->where('name', 'responsable'))->count(),
            'citoyensCount' => User::whereHas('role', fn ($q) => $q->where('name', 'citoyen'))->count(),
        ]);
    }

    public function create()
    {
        return view('admins.users.create', ['roles' => \App\Models\Role::all()]);
    }

    public function show(User $user)
    {
        return view('admins.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = \App\Models\Role::all();
        return view('admins.users.edit', compact('user', 'roles'));
      
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:30',
            'password' => 'nullable|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->id_role = $request->role_id;

        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->save();
        ActivityLogger::log('update', "Utilisateur mis à jour : {$user->email}");

        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        ActivityLogger::log('delete', "Utilisateur supprimé : {$user->email}");
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé.');
    }
}