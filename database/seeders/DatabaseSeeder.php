<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $adminRole = Role::factory()->create(['name' => Role::ADMIN]);
        $vendorRole = Role::factory()->create(['name' => Role::VENDOR]);
        $guestRole = Role::factory()->create(['name' => Role::GUEST]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@events.com',
        ])->role($adminRole);

        User::factory(9)->create([
            'role_id' => $adminRole->id,
        ]);

        User::factory(20)->create([
            'role_id' => $vendorRole->id,
        ]);

        User::factory(100)->create([
            'role_id' => $guestRole->id,
        ]);

    }
}
