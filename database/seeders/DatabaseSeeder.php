<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\QuestionSeeder;
use App\Models\Question; // ★ Questionモデルをuseする

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 既存のユーザーを作成
        User::factory()->create([
            'username' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 追加のユーザーをいくつか作成する
        User::factory(10)->create(); // ★ 10人のダミーユーザーを作成

        // QuestionFactory を使ってダミーの質問をいくつか作成する
        Question::factory(20)->create(); // ★ 20件のダミー質問を作成
    }
}