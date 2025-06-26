<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'answer_id',
        'content',
    ];

    /**
     * このコメントを所有するユーザーを取得する
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * このコメントが関連する回答を取得する
     */
    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}
