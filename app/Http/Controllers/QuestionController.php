<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer; // Answerモデルをuseする
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ソート順の初期化と取得
        $sortBy = $request->query('sort_by', 'latest'); // デフォルトは 'latest'
        // ステータスフィルターの初期化と取得
        $statusFilter = $request->query('status_filter', 'all'); // デフォルトは 'all'
        // 検索クエリの取得
        $searchQuery = $request->query('search'); // ★検索クエリを取得

        $questions = Question::with(['user', 'answers.user']);

        // ★検索ロジックを追加
        if ($searchQuery) {
            $questions->where(function ($query) use ($searchQuery) {
                $query->where('title', 'like', '%' . $searchQuery . '%')
                      ->orWhere('body', 'like', '%' . $searchQuery . '%'); // bodyカラムを検索
            });
        }

        // ステータスフィルターロジック
        if ($statusFilter === 'open') {
            $questions->where('is_resolved', false);
        } elseif ($statusFilter === 'resolved') {
            $questions->where('is_resolved', true);
        }

        // ソートロジック
        if ($sortBy === 'oldest') {
            $questions->oldest();
        } elseif ($sortBy === 'most_answers') {
            // 回答数でソートするために結合とカウント
            $questions->withCount('answers')->orderByDesc('answers_count');
        } else { // 'latest' (デフォルト)
            $questions->latest();
        }

        $questions = $questions->paginate(10);

        // $sortBy と $statusFilter, $searchQuery 変数をビューに渡す
        return view('questions.index', compact('questions', 'sortBy', 'statusFilter', 'searchQuery')); // ★searchQueryも渡す
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Auth::user()->questions()->create($request->all());

        return redirect()->route('questions.index')->with('success', '質問が投稿されました！');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        $question->load(['user', 'answers.user', 'answers.comments.user']); // コメントユーザーもロード
        $isBookmarked = Auth::check() ? $question->bookmarks()->where('user_id', Auth::id())->exists() : false;
        return view('questions.show', compact('question', 'isBookmarked'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        $this->authorize('update', $question); // ポリシーによる認可
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $this->authorize('update', $question); // ポリシーによる認可

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $question->update($request->all());

        return redirect()->route('questions.show', $question)->with('success', '質問が更新されました！');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $this->authorize('delete', $question); // ポリシーによる認可
        $question->delete();
        return redirect()->route('questions.index')->with('success', '質問が削除されました！');
    }

    /**
     * Mark an answer as the best answer.
     */
    public function markAsBestAnswer(Request $request, Question $question, Answer $answer)
    {
        // 質問の所有者のみがベストアンサーを選べるようにする
        if (Auth::id() !== $question->user_id) {
            return back()->with('error', 'この質問のベストアンサーを選ぶ権限がありません。');
        }

        // ベストアンサーIDを更新
        $question->best_answer_id = $answer->id;
        $question->is_resolved = true; // ★この行が重要：質問を解決済みにする
        $question->save();

        return back()->with('success', 'ベストアンサーが選ばれました！');
    }
}
