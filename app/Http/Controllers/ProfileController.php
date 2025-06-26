<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

// 各モデルをインポート
use App\Models\Question;
use App\Models\Answer;
use App\Models\Comment;

class ProfileController extends Controller
{
    /**
     * ユーザーのプロフィール表示フォームと関連するデータ（質問、回答、コメント）を表示します。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // 認証済みユーザーが投稿した質問を最新順で取得
        $myQuestions = Question::where('user_id', $user->id)
                               ->orderByDesc('created_at')
                               ->get();

        // 認証済みユーザーが投稿した回答を最新順で取得し、関連する質問もロード
        $myAnswers = Answer::where('user_id', $user->id)
                           ->with('question')
                           ->orderByDesc('created_at')
                           ->get();

        // 認証済みユーザーが投稿したコメントを最新順で取得し、関連する回答と質問もロード
        $myComments = Comment::where('user_id', $user->id)
                             ->with('answer.question')
                             ->orderByDesc('created_at')
                             ->get();
        
        // プロフィール編集ビューにユーザーデータと取得した各種リストを渡す
        return view('profile.edit', [
            'user' => $user,
            'myQuestions' => $myQuestions,
            'myAnswers' => $myAnswers,
            'myComments' => $myComments,
        ]);
    }

    /**
     * ユーザーのプロフィール情報を更新します。
     * メールアドレスが変更された場合、未認証状態に戻します。
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // バリデーション済みのリクエストデータでユーザーモデルを更新
        $request->user()->fill($request->validated());

        // メールアドレスが変更された場合、メール認証日時をnullにする
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // ユーザー情報をデータベースに保存
        $request->user()->save();

        // プロフィール編集ページへリダイレクトし、成功メッセージをセッションにフラッシュ
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * ユーザーアカウントを削除します。
     * 削除前にパスワード認証を要求します。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        // ユーザー削除に関するバリデーション（パスワードの確認）
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'], // パスワードは必須で、現在のパスワードと一致すること
        ]);

        $user = $request->user(); // 認証済みユーザーを取得

        Auth::logout(); // ユーザーをログアウトさせる

        $user->delete(); // ユーザーアカウントをデータベースから削除

        // セッションを無効にし、新しいトークンを再生成
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // トップページにリダイレクト
        return Redirect::to('/');
    }
}

