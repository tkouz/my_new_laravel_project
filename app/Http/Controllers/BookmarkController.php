<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class BookmarkController extends Controller
{
    /**
     * ブックマークを保存する。
     */
    public function store(Request $request, Question $question): RedirectResponse
    {
        // 既にブックマーク済みか確認
        if (!Auth::user()->bookmarks()->where('question_id', $question->id)->exists()) {
            Auth::user()->bookmarks()->attach($question->id);
        }

        return back()->with('status', '質問をブックマークしました。');
    }

    /**
     * ブックマークを削除する。
     */
    public function destroy(Question $question): RedirectResponse
    {
        Auth::user()->bookmarks()->detach($question->id);

        return back()->with('status', 'ブックマークを解除しました。');
    }
}
