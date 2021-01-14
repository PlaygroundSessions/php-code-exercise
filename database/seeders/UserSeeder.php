<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    const QTY = 5;

    public function run(): void
    {
        User::factory()
            ->count(self::QTY)
            ->create();
    }
}
