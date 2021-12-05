<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(OptionSeeder::class);

        $user = \App\User::where('email', 'mohsen.4887@gmail.com')->first();
        $user->assignRole('superadmin');

        \Illuminate\Support\Facades\DB::unprepared(file_get_contents(__DIR__ . '\limod.sql'));
    }
}
