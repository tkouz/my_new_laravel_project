<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory;

    /**
     * モデルの「一括割り当て可能」な属性。
     * （create() や update() メソッドで一度に設定できるカラム）
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',          // 回答投稿者のID
        'question_id',      // 回答が紐付く質問のID
        'content',          // 回答の内容
        'is_best_answer',   // この回答がベストアンサーであるか (boolean)
    ];

    /**
     * 型キャストする必要がある属性。
     * データベースから取得したデータを特定の型に変換します。
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_best_answer' => 'boolean', // 'is_best_answer' カラムをboolean型にキャスト
    ];

    /**
     * この回答を投稿したユーザーを取得します。
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * この回答が属する質問を取得します。
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * この回答に紐付く全てのコメントを取得します。
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
