<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    // ブックマークテーブルはuser_idとquestion_idの複合主キーなので、idを持たない
    // デフォルトの主キー(id)を使用しないことを示す
    public $incrementing = false; 

    // 主キーの型がBigIntではない場合、指定する
    // protected $keyType = 'string'; 

    // モデルが使用する主キーのカラム名を指定（複合主キーの場合は通常定義しない）
    // protected $primaryKey = ['user_id', 'question_id']; 
    // Laravelは複合主キーを直接サポートしていないため、この方法は動作しない。
    // そのため、複合主キーの場合はEloquentの操作で工夫が必要。

    /**
     * The attributes that are mass assignable.
     * * ブックマークテーブルは中間テーブルであり、主キーが複合なので
     * 通常は $fillable を設定せず、リレーションシップを通じて操作。
     * 必要に応じて、timestamps() で生成される created_at や updated_at も含める。
     */
    protected $fillable = [
        'user_id',
        'question_id',
    ];


    /**
     * Get the user that owns the bookmark.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the question that the bookmark belongs to.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}