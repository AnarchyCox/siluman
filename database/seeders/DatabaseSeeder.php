<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();
        $userdata = 
        [
            [
            'name' => 'Pusat',
            'username' => 'pusat',
            'password' => '123123',
            'email' => 'pusat@gmail.com',
            'role' => 'pusat',
            ],
             [
            'name' => 'UPPT',
            'username' => 'uppt',
            'password' => '123123',
            'email' => 'uppt@gmail.com',
            'role' => 'uppt',
             ],
            [
            'name' => 'Peta Pusat',
            'username' => 'peta',
            'password' => '123123',
            'email' => 'peta@gmail.com',
            'role' => 'peta',
            ]  
        ];
        foreach($userdata as $user)
        User::factory()->create($user);
    }
}
