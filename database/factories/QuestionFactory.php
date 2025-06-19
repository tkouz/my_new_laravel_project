<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User; // Userモデルをuseする
use App\Models\Question; // Questionモデルをuseする

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * The name of the corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // user_id は既存のユーザーからランダムに選ぶ
        $userId = User::inRandomOrder()->first()->id ?? User::factory()->create()->id;

        return [
            'title' => fake()->sentence(),
            'content' => fake()->paragraph(3),
            'image_path' => fake()->imageUrl(640, 480, 'animals', true), // ★この行を修正
            'user_id' => $userId,
            'is_visible' => fake()->boolean(),
        ];
    }
}