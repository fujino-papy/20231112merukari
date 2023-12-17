<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'users_id' => User::factory(),
            // UserFactoryを使用してユーザーを作成
            'name' => $this->faker->word,
            'categories_id' => \App\Models\Category::inRandomOrder()->first()->id,
            'conditions_id' => \App\Models\Condition::inRandomOrder()->first()->id,
            'summary' => $this->faker->sentence,
            'image_url' => $this->faker->imageUrl($width = 320, $height = 240),
            'price' => $this->faker->numberBetween(100, 1000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
