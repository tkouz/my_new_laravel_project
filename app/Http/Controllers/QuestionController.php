<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth; // ★追加

class QuestionController extends Controller
{
    /**
     * 質問一覧を表示する
     */
    public function index(Request $request): View
    {
        $keyword = $request->input('keyword');
        $query = Question::query();
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('content', 'LIKE', "%{$keyword}%");
            });
        }
        $questions = $query->with('user')->get();
        return view('questions.index', compact('questions'));
    }

    /**
     * 特定の質問の詳細を表示する
     */
    public function show(Question $question): View
    {
        $question->load('answers.user');
        return view('questions.show', compact('question'));
    }

    /**
     * 質問投稿フォームを表示する
     */
    public function create(): View
    {
        return view('questions.create');
    }

    /**
     * 新しい質問をデータベースに保存する
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        Question::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'status' => 'open',
            'is_visible' => true,
        ]);
        return redirect()->route('questions.index')->with('status', '質問が投稿されました！');
    }

    // ★ここから追加: 質問編集・更新・削除メソッド

    /**
     * 質問編集フォームを表示する
     */
    public function edit(Question $question): View
    {
        // 認可チェック: ログインユーザーが質問の投稿者であるか
        // abort_if(Auth::id() !== $question->user_id, 403); // もしUserモデルにisOwnerメソッドがあれば
        // またはシンプルに
        if (Auth::id() !== $question->user_id) {
            abort(403, 'Unauthorized action.'); // 403 Forbidden エラーを返す
        }

        return view('questions.edit', compact('question'));
    }

    /**
     * 質問をデータベースで更新する
     */
    public function update(Request $request, Question $question): RedirectResponse
    {
        // 認可チェック: ログインユーザーが質問の投稿者であるか
        if (Auth::id() !== $question->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // バリデーションルールを定義
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // データベースを更新
        $question->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // 更新後、質問詳細ページにリダイレクト
        return redirect()->route('questions.show', $question)->with('status', '質問が更新されました！');
    }

    /**
     * 質問をデータベースから削除する
     */
    public function destroy(Question $question): RedirectResponse
    {
        // 認可チェック: ログインユーザーが質問の投稿者であるか
        if (Auth::id() !== $question->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // データベースから削除
        $question->delete();

        // 削除後、質問一覧ページにリダイレクト
        return redirect()->route('questions.index')->with('status', '質問が削除されました。');
    }
}