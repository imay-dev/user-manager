<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = (int)$this->command->ask('How many users to generate?', 10);
        $this->command->info("Creating {$count} users.");

        UserFactory::times($count)->create();

        $this->command->info('Users Created!');
    }
}
