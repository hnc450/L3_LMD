<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Service::factory(10)->create();

        $roles = Role::pluck('id', 'name');

        User::create([
            'name' => 'Admin Système',
            'email' => 'admin@plaintes.cd',
            'password' => 'password',
            'phone' => '+243900000001',
            'id_role' => $roles['admin'],
        ]);

        User::create([
            'name' => 'Agent Terrain',
            'email' => 'agent@plaintes.cd',
            'password' => 'password',
            'phone' => '+243900000002',
            'id_role' => $roles['agent'],
        ]);

        User::create([
            'name' => 'Responsable Service',
            'email' => 'responsable@plaintes.cd',
            'password' => 'password',
            'phone' => '+243900000003',
            'id_role' => $roles['responsable'] ?? $roles['admin'],
        ]);

        User::create([
            'name' => 'Citoyen Test',
            'email' => 'citoyen@plaintes.cd',
            'password' => 'password',
            'phone' => '+243900000004',
            'id_role' => $roles['citoyen'],
        ]);

        $responsable = User::where('email', 'responsable@plaintes.cd')->first();
        if ($responsable && Service::exists()) {
            Service::first()?->update(['responsable_id' => $responsable->id]);
        }
    }
}
