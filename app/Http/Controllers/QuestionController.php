<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * 質問一覧を表示する
     */
    public function index(Request $request): View
    {
        $keyword = $request->input('keyword');
        $sortBy = $request->input('sort_by', 'latest');
        $statusFilter = $request->input('status_filter', 'all'); // ★この行を追加: デフォルトは「全て」

        $query = Question::query();

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('content', 'LIKE', "%{$keyword}%");
            });
        }

        // ★ここから追加: ステータスによる絞り込みロジック
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }
        // ★追加ここまで

        $query->withCount('answers');

        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'most_answers':
                $query->orderByDesc('answers_count');
                break;
            case 'latest':
            default:
                $query->orderByDesc('created_at');
                break;
        }

        $questions = $query->with('user')->paginate(10);

        // statusFilterもビューに渡す
        return view('questions.index', compact('questions', 'sortBy', 'statusFilter'));
    }

    /**
     * 特定の質問の詳細を表示する (既存)
     */
    public function show(Question $question): View
    {
        $question->load(['answers.user', 'answers.comments.user']);
        return view('questions.show', compact('question'));
    }

    /**
     * 質問投稿フォームを表示する (既存)
     */
    public function create(): View
    {
        return view('questions.create');
    }

    /**
     * 新しい質問をデータベースに保存する (既存)
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

    /**
     * 質問編集フォームを表示する (既存)
     */
    public function edit(Question $question): View
    {
        if (Auth::id() !== $question->user_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('questions.edit', compact('question'));
    }

    /**
     * 質問をデータベースで更新する (既存)
     */
    public function update(Request $request, Question $question): RedirectResponse
    {
        if (Auth::id() !== $question->user_id) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $question->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);
        return redirect()->route('questions.show', $question)->with('status', '質問が更新されました！');
    }

    /**
     * 質問をデータベースから削除する (既存)
     */
    public function destroy(Question $question): RedirectResponse
    {
        if (Auth::id() !== $question->user_id) {
            abort(403, 'Unauthorized action.');
        }
        $question->delete();
        return redirect()->route('questions.index')->with('status', '質問が削除されました。');
    }

    /**
     * 指定された回答をベストアンサーとしてマークし、質問を解決済みにする。 (既存)
     */
    public function markAsBestAnswer(Question $question, Answer $answer): RedirectResponse
    {
        if (Auth::id() !== $question->user_id) {
            return redirect()->back()->with('error', 'この質問のベストアンサーを選定する権限がありません。');
        }
        if ($answer->question_id !== $question->id) {
            return redirect()->back()->with('error', '指定された回答はこの質問に属していません。');
        }
        $currentBestAnswer = $question->answers()->where('is_best_answer', true)->first();
        if ($currentBestAnswer && $currentBestAnswer->id !== $answer->id) {
            $currentBestAnswer->update(['is_best_answer' => false]);
        }
        $answer->update(['is_best_answer' => true]);
        $question->update(['status' => 'resolved']);
        return redirect()->back()->with('status', 'ベストアンサーが選定され、質問が解決済みに変更されました！');
    }
}
