<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image_path',
        'is_visible',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_visible' => 'boolean',
    ];

    /**
     * この質問を投稿したユーザーを取得する
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * この質問に属する回答を取得する
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * この質問に対するブックマークを取得する
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}