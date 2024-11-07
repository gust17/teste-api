<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = 'senha@123';


        User::create([
            'name' => 'Usuário 1',
            'email' => 'usuario1@example.com',
            'password' => Hash::make($password),
        ]);

        User::create([
            'name' => 'Usuário 2',
            'email' => 'usuario2@example.com',
            'password' => Hash::make($password),
        ]);

        User::create([
            'name' => 'Usuário 3',
            'email' => 'usuario3@example.com',
            'password' => Hash::make($password),
        ]);

        User::create([
            'name' => 'Usuário 4',
            'email' => 'usuario4@example.com',
            'password' => Hash::make($password),
        ]);
    }
}
