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
        Schema::create('bookmarks', function (Blueprint $table) {
            // 複合主キーの設定
            // user_id と question_id がセットでユニークなレコードを識別
            $table->foreignId('user_id')->constrained()->comment('ユーザーID'); // 必須
            $table->foreignId('question_id')->constrained()->comment('質問ID'); // 必須
            
            $table->primary(['user_id', 'question_id']); // 複合主キーとして設定

            // created_at (ブックマーク日時として利用) と updated_at を生成
            // テーブル定義書にある 'bookmarked_at' は created_at で代替。
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};