<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // 必要なければコメントアウトのままでOK
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Bookmark; // Bookmarkモデルを使っているならこの行も追加


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     *
     * @var string
     */


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

    // ここからリレーションメソッドの追加（以前のコードから持ってくる）
    /**
     * このユーザーが投稿した質問を取得する
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * このユーザーが投稿した回答を取得する
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * このユーザーがブックマークした質問を取得する
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
    // ここまでリレーションメソッドの追加
}