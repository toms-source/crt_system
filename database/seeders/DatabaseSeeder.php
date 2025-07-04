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
        $admin = User::factory()->create([
            'name' => 'Admin Admin',
            'email' => 'admin@transco.com.ph',
            'password' => static::$password ??=Hash::make('password')
        ]);
        $admin -> assignRole('admin');
    }
}
