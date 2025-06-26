<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse; // ★追加
use App\Models\Answer; // ★追加 (コメント対象の回答と紐付けるため)
use App\Models\Comment; // ★追加
use Illuminate\Support\Facades\Auth; // ★追加

class CommentController extends Controller
{
    /**
     * 新しいコメントをデータベースに保存する
     */
    public function store(Request $request, Answer $answer): RedirectResponse
    {
        // バリデーションルールを定義
        $request->validate([
            'content' => 'required|string|max:500', // コメント内容を必須とし、最大文字数も設定
        ]);

        // データベースに保存
        Comment::create([
            'user_id' => Auth::id(), // ログイン中のユーザーIDを自動で設定
            'answer_id' => $answer->id, // URLから渡された回答IDを取得
            'content' => $request->content,
        ]);

        // コメント投稿後、質問詳細ページ（コメントが属する回答が表示されているページ）にリダイレクト
        // 回答が属する質問を取得し、その質問の詳細ページへリダイレクト
        return redirect()->route('questions.show', $answer->question_id)->with('status', 'コメントが投稿されました！');
    }
}
