<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'best_answer_id', // ベストアンサーIDを追加
        'is_resolved',    // ★この行が重要：解決済みフラグ
    ];

    protected $casts = [
        'is_resolved' => 'boolean', // is_resolved をboolean型としてキャストする
    ];

    /**
     * Get the user that owns the question.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the answers for the question.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Get the best answer for the question.
     */
    public function bestAnswer(): BelongsTo
    {
        return $this->belongsTo(Answer::class, 'best_answer_id');
    }

    /**
     * Get the bookmarks for the question.
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }
}
