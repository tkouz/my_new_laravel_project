<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

// Question, Answer, Comment モデルをインポート
use App\Models\Question;
use App\Models\Answer;
use App\Models\Comment;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // 自分の質問のデータを取得
        $myQuestions = Question::where('user_id', $user->id)
                               ->orderByDesc('created_at')
                               ->get();

        // 自分の回答のデータを取得
        $myAnswers = Answer::where('user_id', $user->id)
                           ->with('question') // 回答がどの質問に対するものか表示するためにリレーションをロード
                           ->orderByDesc('created_at')
                           ->get();

        // 自分のコメントのデータを取得
        $myComments = Comment::where('user_id', $user->id)
                             ->with('answer.question') // コメントがどの回答のどの質問に対するものか表示するためにリレーションをロード
                             ->orderByDesc('created_at')
                             ->get();
        
        // ブックマークはUserモデルのリレーションから直接取得できる

        return view('profile.edit', [
            'user' => $user,
            'myQuestions' => $myQuestions, // ビューに渡す
            'myAnswers' => $myAnswers,     // ビューに渡す
            'myComments' => $myComments,   // ビューに渡す
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
