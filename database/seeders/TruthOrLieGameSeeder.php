<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use k1fl1k\truefalsegame\Models\TruthOrLieGame;
use k1fl1k\truefalsegame\Models\User;

class TruthOrLieGameSeeder extends Seeder
{
    public function run(): void
    {
        TruthOrLieGame::factory()->count(10)->create();
    }
}
