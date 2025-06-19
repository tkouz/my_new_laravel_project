<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// DB::raw() を使う場合に備えて追加（もしCURRENT_TIMESTAMPを使うなら）
// use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // 主キー

            // 外部キー answer_id (answersテーブルを参照)
            $table->foreignId('answer_id')->constrained()->comment('回答ID'); // 必須

            $table->text('content')->comment('コメント本文'); // 必須

            // 外部キー user_id (usersテーブルを参照)
            $table->foreignId('user_id')->constrained()->comment('ユーザーID'); // 必須

            // created_at (投稿日時として利用) と updated_at (更新日時) を生成
            // テーブル定義書にある 'posted_at' は created_at で代替。
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};