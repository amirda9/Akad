<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'محسن صفری',
            'email' => 'mohsen.4887@gmail.com',
            'mobile' => '09107565828',
            'is_active' => true,
        ]);
    }
}
