<?php

namespace Modules\User\Database\Seeders;

use Modules\User\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)->create();
    }
}
