<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'question_id',
        'content',
        'is_best_answer',
        'is_visible',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_best_answer' => 'boolean', // この行は追加されていなかったので追加します
        'is_visible' => 'boolean',
    ];

    /**
     * この回答が属する質問を取得する
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * この回答を投稿したユーザーを取得する
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * この回答に対するコメントを取得する
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}