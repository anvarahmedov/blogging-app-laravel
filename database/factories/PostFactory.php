<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'image' => $this->faker->imageUrl(),
            'title' => $this->faker->sentence(),
            'slug'=> $this->faker->slug(3),
            'body' => $this->faker->paragraph(10),
            'published_at' => $this->faker->dateTimeBetween('-1 Week'),
            'featured' => $this->faker->boolean(15)
        ];
    }
}
