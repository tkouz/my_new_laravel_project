<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question; // Questionモデルをインポート
use App\Models\Answer;   // Answerモデルをインポート
use Illuminate\Http\RedirectResponse; // RedirectResponseをインポート

class AnswerController extends Controller
{
    /**
     * 指定された質問に対して新しい回答をデータベースに保存します。
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question  回答を投稿する対象の質問モデルのインスタンス
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Question $question): RedirectResponse
    {
        // リクエストデータのバリデーション
        $request->validate([
            'content' => 'required|string', // 回答内容は必須、文字列
        ]);

        // 新しい回答をデータベースに作成
        $answer = new Answer([
            'user_id' => auth()->id(),      // 認証済みユーザーのIDを回答者とする
            'question_id' => $question->id, // 回答が属する質問のID
            'content' => $request->content, // リクエストから回答内容を取得
            'is_best_answer' => false,      // デフォルトではベストアンサーではない
        ]);

        // 回答を保存
        $answer->save();

        // 質問の詳細ページへリダイレクトし、成功メッセージをセッションにフラッシュ
        return redirect()->route('questions.show', $question)->with('status', '回答が投稿されました！');
    }
}
