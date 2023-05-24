<?php

namespace Database\Seeders;

use App\Models\DynamicField;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->defaultUser()->create();
        DynamicField::factory()->count(10)->create();
    }
}
