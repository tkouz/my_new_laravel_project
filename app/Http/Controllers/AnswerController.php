<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse; // ★追加
use App\Models\Answer; // ★追加
use App\Models\Question; // ★追加 (質問と紐付けるため)

class AnswerController extends Controller
{
    /**
     * 新しい回答をデータベースに保存する
     */
    public function store(Request $request, Question $question): RedirectResponse
    {
        // バリデーションルールを定義
        $request->validate([
            'content' => 'required|string',
        ]);

        // データベースに保存
        // ログイン中のユーザーIDと、URLから渡された質問IDを紐付ける
        Answer::create([
            'user_id' => auth()->id(), // ログイン中のユーザーIDを自動で設定
            'question_id' => $question->id, // URLの質問からIDを取得
            'content' => $request->content,
        ]);

        // 保存後、質問詳細ページにリダイレクト
        return redirect()->route('questions.show', $question)->with('status', '回答が投稿されました！');
    }
}