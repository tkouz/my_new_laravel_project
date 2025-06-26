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

// 質問一覧ページのルート
Route::get('/questions', [QuestionController::class, 'index'])
     ->name('questions.index');

// 認証済みユーザーのみがアクセスできるルート
Route::middleware('auth')->group(function () {
    // 質問投稿フォームのルートは、動的なルートより上に配置する
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create'); // フォーム表示
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store'); // フォーム送信

    // 質問の編集・更新・削除に関するルート
    // 質問編集フォームの表示
    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    // 質問の更新
    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    // 質問の削除
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

    // 回答投稿に関するルート
    Route::post('/questions/{question}/answers', [AnswerController::class, 'store'])->name('answers.store');

    // ブックマークに関するルート
    // 質問をブックマークする
    Route::post('/questions/{question}/bookmark', [BookmarkController::class, 'store'])->name('bookmark.store');
    // 質問のブックマークを解除する
    Route::delete('/questions/{question}/bookmark', [BookmarkController::class, 'destroy'])->name('bookmark.destroy');

    // コメント投稿に関するルート
    // 特定の回答に対するコメントを投稿するルート
    Route::post('/answers/{answer}/comments', [CommentController::class, 'store'])->name('comments.store');

    // プロフィール関連
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ベストアンサー選定ルート
    // 質問に属する特定の回答をベストアンサーとしてマークする
    Route::post('/questions/{question}/answers/{answer}/best', [QuestionController::class, 'markAsBestAnswer'])->name('answers.markAsBestAnswer');
});

// 質問詳細ページのルートは、createルートよりも下に配置する
Route::get('/questions/{question}', [QuestionController::class, 'show'])
     ->name('questions.show');

require __DIR__.'/auth.php';
