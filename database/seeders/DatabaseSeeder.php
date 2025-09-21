<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Preference;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'van',
            'last_name' => 'hup',
            'password' => Hash::make('12345678'),
            'email' => 'admin@gmail.com',
            'role'  => 'admin',
        ]);

        Preference::factory()->create(['name' => 'Taste']);
        Preference::factory()->create(['name' => 'Health']);
        Preference::factory()->create(['name' => 'Culture']);
        Preference::factory()->create(['name' => 'Ethics']);

    }
}
