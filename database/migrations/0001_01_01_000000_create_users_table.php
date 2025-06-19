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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // テーブル定義書に合わせて name -> username に変更し、コメント追加
            $table->string('username', 255)->comment('ユーザー名'); 
            $table->string('email')->unique()->comment('メールアドレス');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->comment('パスワードハッシュ'); // Laravelの認証機能に合わせてカラム名はpasswordのまま
            $table->rememberToken();
            
            // 追加カラム
            $table->string('profile_image', 255)->nullable()->comment('プロフィール画像');
            $table->text('self_introduction')->nullable()->comment('自己紹介文');
            $table->timestamp('last_login_at')->nullable()->comment('最終ログイン日時');
            $table->timestamp('registered_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('登録日時');
            $table->enum('role', ['general', 'admin'])->default('general')->comment('ユーザーロール');
            $table->boolean('is_active')->default(true)->comment('有効フラグ');
            
            $table->timestamps(); // created_at と updated_at を生成
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};