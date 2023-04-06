<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user for the system

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@saraha.com',
            'password' => bcrypt('12345678'),
            'is_admin' => true
        ]);

        // Create regular user (non-admin) for the system 

        DB::table('users')->insert([
            'name' => 'test',
            'email' => 'test@saraha.com',
            'password' => bcrypt('12345678'),
            'is_admin' => false
        ]);

        // Seed additional users for the system

        User::factory()->count(10)->create();
    }
}
