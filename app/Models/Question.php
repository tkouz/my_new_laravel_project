<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // BelongsToManyをインポート

class Question extends Model
{
    use HasFactory;

    /**
     * モデルの「一括割り当て可能」な属性。
     * （create() や update() メソッドで一度に設定できるカラム）
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',      // 質問投稿者のID
        'title',        // 質問のタイトル
        'content',      // 質問の内容
        'image_path',   // (もし画像パスを保存する場合)
        'is_visible',   // 質問が公開されているか (boolean)
        'status',       // 質問のステータス (例: 'open', 'resolved')
    ];

    /**
     * モデルの属性のデフォルト値。
     * 新しいモデルが作成される際に自動的に設定されます。
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => 'open', // 質問のデフォルトステータスを「未解決」に設定
    ];

    /**
     * 型キャストする必要がある属性。
     * データベースから取得したデータを特定の型に変換します。
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_visible' => 'boolean', // 'is_visible' カラムをboolean型にキャスト
    ];

    /**
     * この質問に紐付く全ての回答を取得します。
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * この質問を投稿したユーザーを取得します。
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * この質問をブックマークした全てのユーザーを取得します。
     * 'bookmarks'は中間テーブル名、'question_id'はこのモデルの外部キー、'user_id'は関連モデルの外部キー。
     * withTimestamps()は中間テーブルのcreated_atとupdated_atを自動で更新します。
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmarks', 'question_id', 'user_id')->withTimestamps();
    }
}
