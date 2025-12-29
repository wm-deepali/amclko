<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'email'           => 'admin@gmail.com',
            'name'            => 'Academy of Mass Communication',
            'password'        => Hash::make('Admin@123'), // ✅ bcrypt
            'phone'           => '9792617555',
            'address'         => 'Main Office Address',
            'city'            => 'Lucknow',
            'zipcode'         => '226010',
            'state'           => 'Uttar Pradesh',
            'country'         => 0,
            'user_role'       => 'admin',
            'account_confirm' => 'confirm',
            'account_status'  => 'active',
        ]);
    }
}
