<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admins.index');
    }
    public function users(){
        $users = User::paginate(50);
        $userCount = User::count();
        $adminCount = User::where('id_role', 3)->count();
        $responsablesCount = User::where('id_role', 4)->count();
        $citoyensCount = User::where('id_role', 1)->count();
        return view('admins.users', compact('users', 'userCount', 'adminCount', 'responsablesCount', 'citoyensCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = \App\Models\Role::all();
        return view('admins.users.create', compact('roles'));
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $user = \App\Models\User::findOrFail($id);
        return view('admins.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admins.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
public function updateUser(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'nullable|string|max:30',
        'password' => 'nullable|min:8|confirmed',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->update();

    return redirect()
        ->route('admin.users')
        ->with('success', 'Utilisateur mis à jour avec succès.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    

public function destroyUser(User $user)
{
    // Empêcher un administrateur de supprimer son propre compte
    if ($user->id === auth()->id()) {
        return redirect()
            ->back()
            ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
    }

    $user->delete();

    return redirect()
        ->route('admin.users')
        ->with('success', 'Utilisateur supprimé avec succès.');
}
}
