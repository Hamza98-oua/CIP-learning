<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Test',
            'email' => 'admin@ofppt.ma',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Formateur Test',
            'email' => 'formateur@ofppt.ma',
            'password' => bcrypt('password'),
            'role' => 'formateur'
        ]);

        User::create([
            'name' => 'Stagiaire Test',
            'email' => 'stagiaire@ofppt.ma',
            'password' => bcrypt('password'),
            'role' => 'stagiaire'
        ]);
    }
}
