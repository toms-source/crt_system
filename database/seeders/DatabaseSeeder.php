<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    protected static ?string $password;
    public function run(): void
    {
        // $managers = User::factory(20)->create();

        // $managers->each(function ($user) {
        //     $user->assignRole('user');
        // });
        // $user = User::factory(10)->create();
        // $user -> assignRole('user');


        $admin = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => static::$password ??=Hash::make('password')
        ]);
        $admin -> assignRole('admin');
    }
}
