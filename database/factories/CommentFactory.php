<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $created = fake()->dateTimeBetween('-5 years', 'now');
        $updated = fake()->dateTimeBetween($created, 'now');

        if(rand(0,9) !== 0){
            $updated = $created;
        }
        return [
            'body' => fake()->sentences(3, true),
            'article_id' => Article::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'created_at' => $created,
            'updated_at' => $updated,
        ];
    }
}
