<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // 必要なければコメントアウトのままでOK
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// App\Models\Question は不要 (直接Questionモデルを使わずリレーションで取得するため)
// App\Models\Answer は不要 (直接Answerモデルを使わずリレーションで取得するため)
// App\Models\Bookmark は不要 (直接Bookmarkモデルを使わずリレーションで取得するため)
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image_path',
        'bio',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean', // is_active もbooleanにキャストする
        ];
    }

    // ★ここからリレーションメソッド
    /**
     * このユーザーが投稿した質問を取得する
     */
    public function questions(): HasMany // 型ヒントを追加
    {
        return $this->hasMany(Question::class);
    }

    /**
     * このユーザーが投稿した回答を取得する
     */
    public function answers(): HasMany // 型ヒントを追加
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * このユーザーがブックマークした質問を取得する
     */
    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'bookmarks', 'user_id', 'question_id')->withTimestamps();
    }

    /**
     * このユーザーが投稿したコメントを取得する
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    // ★ここまでリレーションメソッド
}
