<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;
        $content = $this->faker->paragraph(5);

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'content' => $content,
            'image' => "https://upload.wikimedia.org/wikipedia/commons/thumb/8/89/Patron_in_Ohmatdyt%2C_28_April_2022_%2804%29.jpg/800px-Patron_in_Ohmatdyt%2C_28_April_2022_%2804%29.jpg",
        ];
    }
}
