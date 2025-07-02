<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// トップページへのアクセスを質問一覧にリダイレクト
Route::get('/', function () {
    return redirect()->route('questions.index');
});

// 質問一覧ページのルート (未認証ユーザーもアクセス可能)
Route::get('/questions', [QuestionController::class, 'index'])
    ->name('questions.index');

// ★修正: 質問投稿フォーム表示のルートをquestions.showよりも前に配置
Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');

// 質問詳細ページのルート (未認証ユーザーもアクセス可能)
Route::get('/questions/{question}', [QuestionController::class, 'show'])
    ->name('questions.show');


// 認証済みユーザーのみがアクセスできるルートグループ
Route::middleware('auth')->group(function () {
    // QuestionControllerに対するリソースルートを定義
    // index, show, create メソッドは上記で定義済みのため除外
    Route::resource('questions', QuestionController::class)->except(['index', 'show', 'create']);

    // 回答投稿に関するルート
    Route::post('/questions/{question}/answers', [AnswerController::class, 'store'])->name('answers.store');

    // ブックマークに関するルート
    Route::post('/questions/{question}/bookmark', [BookmarkController::class, 'store'])->name('bookmark.store');
    Route::delete('/questions/{question}/bookmark', [BookmarkController::class, 'destroy'])->name('bookmark.destroy');

    // コメント投稿に関するルート
    Route::post('/answers/{answer}/comments', [CommentController::class, 'store'])->name('comments.store');

    // プロフィール関連
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ベストアンサー選定ルート
    Route::post('/questions/{question}/answers/{answer}/best', [QuestionController::class, 'markAsBestAnswer'])->name('answers.markAsBestAnswer');
});

// 認証関連のルートをインクルード
require __DIR__.'/auth.php';
