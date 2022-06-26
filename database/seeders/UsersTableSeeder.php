<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    private $providerPassword = 'qwerty';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $passwordHash = Hash::make($this->providerPassword);

        DB::table('users')->insert([
            'name' => 'Ivan',
            'email' => 'evan4mc@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => $passwordHash,
            'payment_account' => 10000,
        ]);
    }
}
