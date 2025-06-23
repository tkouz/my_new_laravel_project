<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse; // ★追加
use App\Models\Question; // ★追加 (質問と紐付けるため)
use Illuminate\Support\Facades\Auth; // ★追加

class BookmarkController extends Controller
{
    /**
     * 指定された質問をブックマークする
     */
    public function store(Request $request, Question $question): RedirectResponse
    {
        // 既にブックマークされているか確認
        if (Auth::user()->bookmarks()->where('question_id', $question->id)->exists()) {
            return redirect()->back()->with('error', 'この質問は既にブックマークされています。');
        }

        // ブックマークを追加
        Auth::user()->bookmarks()->attach($question->id);

        return redirect()->back()->with('status', '質問をブックマークしました！');
    }

    /**
     * 指定された質問のブックマークを解除する
     */
    public function destroy(Request $request, Question $question): RedirectResponse
    {
        // ブックマークされているか確認
        if (!Auth::user()->bookmarks()->where('question_id', $question->id)->exists()) {
            return redirect()->back()->with('error', 'この質問はブックマークされていません。');
        }

        // ブックマークを削除
        Auth::user()->bookmarks()->detach($question->id);

        return redirect()->back()->with('status', '質問のブックマークを解除しました。');
    }
}
