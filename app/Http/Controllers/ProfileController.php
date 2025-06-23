<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Question; // ★追加
use App\Models\Answer;   // ★追加

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // ログインユーザーの質問を取得
        // with('user') は既にログインユーザーであるため不要ですが、将来的な拡張性を考えて残す
        $myQuestions = Question::where('user_id', Auth::id())->with('user')->orderByDesc('created_at')->get();

        // ログインユーザーの回答を取得
        $myAnswers = Answer::where('user_id', Auth::id())->with('question')->orderByDesc('created_at')->get();


        return view('profile.edit', [
            'user' => $request->user(),
            'myQuestions' => $myQuestions, // ★追加
            'myAnswers' => $myAnswers,     // ★追加
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
        $request->validate([
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
