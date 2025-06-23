<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            // user_idカラム (外部キー)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // question_idカラム (外部キー)
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // user_idとquestion_idの組み合わせをユニークに設定
            // これにより、同じユーザーが同じ質問を複数回ブックマークできないようにする
            $table->unique(['user_id', 'question_id']);
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
