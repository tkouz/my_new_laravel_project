<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question; // ★ Questionモデルをuseする

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // とりあえずダミーデータ。後でDBから取得するように変更
        // $questions = [
        //     ['id' => 1, 'title' => 'Laravelのインストール方法', 'content' => 'Docker Composeを使っています。', 'user_name' => 'ユーザーA'],
        //     ['id' => 2, 'title' => 'マイグレーションの実行エラー', 'content' => 'SQLSTATE[42S22]が発生しました。', 'user_name' => 'ユーザーB'],
        // ];

        // ★ DBから質問を全て取得する
        $questions = Question::all();

        return view('questions.index', compact('questions'));
    }

    // 他のメソッド（create, store, show, edit, update, destroy）は後で追加
}