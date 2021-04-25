<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return string[]
     *
     * @psalm-return array{title: string, text: string}
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(50),
            'text' => $this->faker->text(1000),
        ];
    }
}
