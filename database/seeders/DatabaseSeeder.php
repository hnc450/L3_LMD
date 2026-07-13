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
        $roles = Role::pluck('id', 'name');

        User::create([
            'name' => 'henock tumonakiese',
            'email' => 'henoctumonakiese@gmail.com',
            'password' => 'Velonica9',
            'phone' => '+243896500709',
            'id_role' => $roles['admin'],
        ]);
    }
}
