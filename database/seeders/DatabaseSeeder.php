<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Question; // Questionモデルをuse
use App\Models\Answer; // Answerモデルをuse
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ★修正1: ユーザーを常に作成するように変更
        // これにより、質問を作成する際に確実に紐付けるユーザーが存在する
        User::factory(10)->create();

        // ★修正2: 質問を作成する際に user_id を紐付ける
        Question::factory(10)->create([
            'user_id' => User::all()->random()->id, // 作成済みのユーザーからランダムにIDを割り当てる
        ])->each(function ($question) {
            // 各質問に対して、2〜5個の回答を作成し、紐づける
            // 回答にはランダムなユーザーを割り当てる必要がある
            Answer::factory(fake()->numberBetween(2, 5))->create([
                'question_id' => $question->id,
                'user_id' => User::all()->random()->id, // 回答にもユーザーを紐付ける
            ]);
        });
    }
}