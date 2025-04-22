<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use k1fl1k\truefalsegame\Models\TruthOrLieGame;
use k1fl1k\truefalsegame\Models\User;

class TruthOrLieGameFactory extends Factory
{
    protected $model = TruthOrLieGame::class;

    public function definition(): array
    {
        $gameVariants = [
            [
                ['statement' => 'The sky is green.', 'is_true' => false],
                ['statement' => 'Fish can fly.', 'is_true' => false],
                ['statement' => 'Water boils at 100°C.', 'is_true' => true],
            ],
            [
                ['statement' => 'The moon is made of cheese.', 'is_true' => false],
                ['statement' => 'Humans need oxygen to survive.', 'is_true' => true],
                ['statement' => 'Cats can bark.', 'is_true' => false],
            ],
            [
                ['statement' => 'Earth is the third planet from the sun.', 'is_true' => true],
                ['statement' => 'A year has 400 days.', 'is_true' => false],
                ['statement' => 'Fire is cold.', 'is_true' => false],
            ],
        ];

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
            'is_public' => $this->faker->boolean(),
            'image' => $this->faker->optional()->imageUrl(),
            'game_data' => json_encode($this->faker->randomElement($gameVariants)),
        ];
    }
}
