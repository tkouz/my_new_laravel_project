<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question; // Questionモデルをインポート
use Illuminate\Http\RedirectResponse; // RedirectResponseをインポート
use Illuminate\Support\Facades\Auth; // Authファサードをインポート

class BookmarkController extends Controller
{
    /**
     * 指定された質問をブックマークとして保存します。
     * 既にブックマーク済みの場合は何もせず、元のページにリダイレクトします。
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question  ブックマークする質問モデルのインスタンス
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Question $question): RedirectResponse
    {
        // 認証済みユーザーを取得
        $user = Auth::user();

        // 既にブックマーク済みでないか確認し、未ブックマークであればブックマークする
        if (!$user->bookmarks()->where('question_id', $question->id)->exists()) {
            $user->bookmarks()->attach($question->id);
            // 成功メッセージをセッションにフラッシュ
            return redirect()->back()->with('status', '質問をブックマークしました！');
        }

        // 既にブックマーク済みの場合は、情報メッセージをセッションにフラッシュ
        return redirect()->back()->with('status', 'この質問は既にブックマークされています。');
    }

    /**
     * 指定された質問のブックマークを解除します。
     * ブックマークされていない場合は何もせず、元のページにリダイレクトします。
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question  ブックマークを解除する質問モデルのインスタンス
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Question $question): RedirectResponse
    {
        // 認証済みユーザーを取得
        $user = Auth::user();

        // ブックマーク済みであるか確認し、ブックマーク済みであれば解除する
        if ($user->bookmarks()->where('question_id', $question->id)->exists()) {
            $user->bookmarks()->detach($question->id);
            // 成功メッセージをセッションにフラッシュ
            return redirect()->back()->with('status', 'ブックマークを解除しました。');
        }

        // ブックマークされていない場合は、情報メッセージをセッションにフラッシュ
        return redirect()->back()->with('status', 'この質問はブックマークされていません。');
    }
}
