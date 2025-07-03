<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage; // Storageファサードを追加
use App\Models\Question; // Questionモデルを追加
use App\Models\Answer;   // Answerモデルを追加
use App\Models\Comment;  // Commentモデルを追加
use App\Models\User;     // Userモデルを追加 (明示的に)

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // ログインユーザーが投稿した質問、回答、コメントを取得
        // リレーションシップが正しく設定されていることを前提とします。
        // 例えば、Userモデルに hasMany(Question::class) など。
        $userQuestions = $user->questions()->latest()->get();
        $userAnswers = $user->answers()->latest()->get();
        $userComments = $user->comments()->latest()->get();

        return view('profile.edit', [
            'user' => $user,
            'userQuestions' => $userQuestions,
            'userAnswers' => $userAnswers,
            'userComments' => $userComments,
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
