<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Please provide info to register super-admin user.');

        $name = $this->command->ask('Name: ', 'Super Admin');
        $email = $this->command->ask('Email: ', 'admin@users.test');
        $password = $this->command->ask('Password: ', '12345678');
        $passwordConfirm = $this->command->ask('Password Confirmation: ', '12345678');

        if ($password != $passwordConfirm) {
            $this->command->error('Passwords does not match!');
            return;
        }

        $admin = User::create([
            'email' => $email,
            'name'     => $name,
            'password' => $password,
        ]);

        $admin->assignRole('super.admin');
    }
}
