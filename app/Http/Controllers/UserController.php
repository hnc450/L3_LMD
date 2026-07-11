<?php

namespace App\Http\Controllers;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Plainte;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $plaintes = Plainte::with('service','user')
        ->where('id_user', Auth::id()) 
        ->latest()
        ->paginate(10);

    
        return view('users.index', compact('plaintes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{
    $request->validate([

        'name' => ['required','string','max:255'],

        'email' => ['required','email','unique:users,email'],

        'phone' => ['nullable','string','max:30'],

        'role' => ['required'],

        'password' => ['required', 'confirmed','min:8'],

    ]);

    User::create([

        'name' => $request->name,

        'email' => $request->email,

        'phone' => $request->phone,

        'id_role' => $request->role,

        'password' => Hash::make($request->password),

    ]);

    return redirect()
        ->route('admin.users')
        ->with('success','Utilisateur créé avec succès.');
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function settings()
    {
        return view('users.settings');
    }

    public function profile()
    {
        return view('users.profil');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function updateProfile(Request $request)
   {
    $request->validate([
        'name'  => 'required|string|max:255',
        'phone' => 'nullable|string|max:30',
    ]);

    $user = auth()->user();

    $user->update([
        'name'  => $request->name,
        'phone' => $request->phone,
    ]);

    return back()->with('success', 'Votre profil a été mis à jour avec succès.');
  }

  public function updateEmail(Request $request)
{
    $request->validate([
        'email' => ['required', 'email', 'unique:users,email'],
    ]);

    $user = auth()->user();

    $user->email = $request->email;
    $user->save();

    return back()->with('success', 'Adresse e-mail mise à jour.');
}

public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => ['required'],
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    $user = auth()->user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors([
            'current_password' => 'Le mot de passe actuel est incorrect.'
        ]);
    }

    $user->password = Hash::make($request->password);
    $user->save();

    return back()->with('success', 'Mot de passe modifié avec succès.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
