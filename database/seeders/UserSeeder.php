<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::LIST as $name => $email) {
            User::create([
                'name' => $name,
                'age' => 21,
                'email' => $email . '@gmail.com',
                'password' => Hash::make('123123'),
            ]);
        }
    }
}
