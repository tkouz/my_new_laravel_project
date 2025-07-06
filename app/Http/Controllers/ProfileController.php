<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage; // Storageファサードを追加
use App\Models\Question;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // 自分が投稿した質問
        $userQuestions = $user->questions()->latest()->get();

        // 自分が投稿した回答
        // 回答の質問タイトルと本文を表示するために質問もロード
        $userAnswers = $user->answers()->with('question')->latest()->get();

        // 自分が投稿したコメント
        // コメントの回答本文と質問タイトルを表示するために回答と質問もロード
        $userComments = $user->comments()->with('answer.question')->latest()->get();

        // ブックマークした質問
        // Userモデルにbookmarksリレーションシップが定義されていることを前提とします。
        // bookmarksテーブルのcreated_atでソート
        $bookmarkedQuestions = $user->bookmarks()->latest('bookmarks.created_at')->get(); 

        return view('profile.edit', [
            'user' => $user,
            'userQuestions' => $userQuestions,
            'userAnswers' => $userAnswers,
            'userComments' => $userComments,
            'bookmarkedQuestions' => $bookmarkedQuestions, // ここを追加
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
     * Update the user's profile image.
     */
    public function updateImage(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_image' => 'nullable|image|max:2048', // 画像は任意、最大2MB
        ]);

        $user = $request->user();
        $imagePath = $user->profile_image_path; // 現在の画像パス

        if ($request->hasFile('profile_image')) {
            // 古い画像があれば削除
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            // 新しい画像を保存
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user->profile_image_path = $imagePath;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-image-updated');
    }

    /**
     * Delete the user's profile image.
     */
    public function deleteImage(): RedirectResponse
    {
        $user = Auth::user();

        if ($user->profile_image_path) {
            Storage::disk('public')->delete($user->profile_image_path);
            $user->profile_image_path = null;
            $user->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-image-deleted');
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

        // プロフィール画像があれば削除
        if ($user->profile_image_path) {
            Storage::disk('public')->delete($user->profile_image_path);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
