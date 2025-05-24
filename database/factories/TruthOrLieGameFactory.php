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
        $themes = [
            [
                'title' => 'Цікаві факти про космос',
                'description' => 'Перевір свої знання про космос і планети Сонячної системи.',
                'data' => [
                    ['statement' => 'Юпітер є найбільшою планетою в Сонячній системі.', 'is_true' => true],
                    ['statement' => 'Місяць більший за Землю.', 'is_true' => false],
                    ['statement' => 'На Марсі є вода у вигляді льоду.', 'is_true' => true],
                ],
            ],
            [
                'title' => 'Факти про людське тіло',
                'description' => 'Чи знаєш ти, як працює людський організм?',
                'data' => [
                    ['statement' => 'Серце перекачує близько 5 літрів крові за хвилину.', 'is_true' => true],
                    ['statement' => 'У людини 300 кісток у дорослому віці.', 'is_true' => false], // 206
                    ['statement' => 'Людський мозок важить приблизно 1,4 кг.', 'is_true' => true],
                ],
            ],
            [
                'title' => 'Технології та винаходи',
                'description' => 'Гра про відомі технології та винаходи.',
                'data' => [
                    ['statement' => 'Інтернет був створений у 2005 році.', 'is_true' => false],
                    ['statement' => 'Перший iPhone з\'явився у 2007 році.', 'is_true' => true],
                    ['statement' => 'Едісон винайшов інтернет.', 'is_true' => false],
                ],
            ],
            [
                'title' => 'Історичні факти',
                'description' => 'Правда чи вигадка? Перевір історичні знання!',
                'data' => [
                    ['statement' => 'Друга світова війна закінчилась у 1945 році.', 'is_true' => true],
                    ['statement' => 'Єгипетські піраміди були побудовані в XIX столітті.', 'is_true' => false],
                    ['statement' => 'Наполеон був імператором Франції.', 'is_true' => true],
                ],
            ],
        ];

        $theme = $this->faker->randomElement($themes);

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'title' => $theme['title'],
            'description' => $theme['description'],
            'is_public' => $this->faker->boolean(80), // 80% публічні
            'image' => $this->faker->optional(0.6)->imageUrl(640, 480, 'education', true, 'Game'), // 60% ігор зображення
            'game_data' => json_encode($theme['data']),
        ];
    }
}
