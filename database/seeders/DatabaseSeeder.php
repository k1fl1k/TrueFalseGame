<?php

namespace Database\Seeders;

use k1fl1k\truefalsegame\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory(5)->create();
        User::factory(3)->admin()->create();
        $this->call(TruthOrLieGameSeeder::class);
    }
}
