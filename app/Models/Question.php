<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image_path',
        'is_visible',
        'status', // statusカラムを追加
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'open', // statusのデフォルト値を'open'に設定
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_visible' => 'boolean', // is_visibleカラムをboolean型にキャスト
    ];

    /**
     * Get the answers for the question.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Get the user that owns the question.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The questions that belong to the user.
     */
    public function bookmarks()
    {
        return $this->belongsToMany(User::class, 'bookmarks', 'question_id', 'user_id')->withTimestamps();
    }
}
