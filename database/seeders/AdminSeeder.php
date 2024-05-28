<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import the DB facade
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon; // Import the Carbon class

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert admin data into the admins table
        DB::table('admins')->insert([
            'name' => 'Marisol Datahan',
            'email' => 'marisoldatahan@gmail.com',
            'password' => Hash::make('Datahan12'), // Hash the password
            'created_at' => Carbon::now(), // Use Carbon to get the current timestamp
            'updated_at' => Carbon::now(), // Use Carbon to get the current timestamp
        ]);

        // You can add more admin accounts if needed
    }
}
