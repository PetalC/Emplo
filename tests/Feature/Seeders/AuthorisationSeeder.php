<?php

namespace Tests\Feature\Seeders;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\Hash;

class AuthorisationSeeder extends \Illuminate\Database\Seeder
{
    /**
     * Create users with differing roles
     * admin@developer.com
     * admin@nova.com
     * admin@taxonomy.com
     * basic@test.com
     * @return void
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $testPwd = Hash::make('test1234');
        $developerAdmin = User::create([
            'first_name' => 'Developer',
            'last_name' => 'Super',
            'email' => 'admin@developer.com',
            'password' => $testPwd,
            'email_verified_at' => now(),
        ]);

        $developerAdmin->assignRole(['Developer']);

        $novaAdmin = User::create([
            'first_name' => 'Nova',
            'last_name' => 'Admin',
            'email' => 'admin@nova.com',
            'password' => $testPwd,
            'email_verified_at' => now(),
        ]);

        $novaAdmin->assignRole(['Super Admin']);

        $taxonomyOnlyAdmin = User::create([
            'first_name' => 'Taxonomy',
            'last_name' => 'Admin',
            'email' => 'admin@taxonomy.com',
            'password' => $testPwd,
            'email_verified_at' => now(),
        ]);

        $taxonomyOnlyAdmin->assignRole(['Taxonomy Manager']);

        $unauthUser = User::create([
            'first_name' => 'Unauthorised',
            'last_name' => 'User',
            'email' => 'basic@test.com',
            'password' => Hash::make('test1234'),
            'email_verified_at' => now(),
        ]);

        $unauthUser->assignRole([]);

    }
}
