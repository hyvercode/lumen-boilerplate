<?php

namespace Database\Seeders;

use App\Models\User;
use App\Utils\Constants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            "name" => "admin",
            "username" => "admin@homestead.com",
            "email" => "admin@homestead.com",
            "password" => Hash::make("Admin!23"),
            "phone_number" => "628788587000",
            "status" => Constants::ACTIVE
        ]);
        $admin->assignRole('admin');
    }
}
