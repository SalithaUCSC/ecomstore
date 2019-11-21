<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => 1,
            'name' => 'salitha',
            'email' => 'poolsaliya@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('11112222')
        ]);
    }
}
