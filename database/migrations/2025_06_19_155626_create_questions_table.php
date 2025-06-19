<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // DB::raw() を使う場合に必要

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->string('title', 255)->comment('タイトル'); // 必須
            $table->text('content')->comment('質問内容'); // 必須
            $table->string('image_path', 255)->comment('画像パス'); // 必須 (テーブル定義書ではVARCHAR(255) NotNull)
            
            // user_id は外部キー
            $table->foreignId('user_id')->constrained()->comment('ユーザーID'); // 外部キー, 必須, usersテーブルのidを参照

            $table->boolean('is_visible')->default(true)->comment('表示フラグ'); // デフォルト TRUE

            $table->timestamps(); // created_at (投稿日時として利用) と updated_at (更新日時) を生成


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};