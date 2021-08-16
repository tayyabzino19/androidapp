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
        $user = new User;
        $user->name = "Ahmad Ayaz";
        $user->email = "ahmad@gmail.com";
        $user->password = Hash::make('pakistan');
        $user->status = "active";
        $user->photo = "";
        $user->save();


    }
}
