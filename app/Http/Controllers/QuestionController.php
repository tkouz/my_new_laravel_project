<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Question;
use App\Models\Answer; // Answerモデルもuseする (必要であれば、もし使わなければ削除可)

class QuestionController extends Controller
{
    /**
     * 質問一覧を表示する
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // 検索キーワードを取得
        $keyword = $request->input('keyword');

        // クエリビルダの開始
        $query = Question::query();

        // キーワードが入力されている場合、絞り込み条件を追加
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('content', 'LIKE', "%{$keyword}%");
            });
        }

        // ★この行を修正します: with('user') を追加してユーザー情報をEager Loading
        $questions = $query->with('user')->get();

        return view('questions.index', compact('questions'));
    }

    /**
     * 特定の質問の詳細を表示する
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\View\View
     */
    public function show(Question $question)
    {
        // 質問とそれに関連する回答を一緒にロードする（Eager Loading）
        $question->load('answers.user');

        return view('questions.show', compact('question'));
    }

    // 他のメソッド（create, store, edit, update, destroy）は後で追加
}