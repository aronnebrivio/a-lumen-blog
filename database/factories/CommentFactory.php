<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return string[]
     *
     * @psalm-return array{text: string}
     */
    public function definition()
    {
        return [
            'text' => $this->faker->text(300),
        ];
    }
}
