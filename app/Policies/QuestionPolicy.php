<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;
use Illuminate\Auth\Access\Response;

class QuestionPolicy
{
    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Question $question): bool
    {
        // ユーザーが質問の所有者である場合に更新を許可
        return $user->id === $question->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Question $question): bool
    {
        // ユーザーが質問の所有者である場合に削除を許可
        return $user->id === $question->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Question $question): bool
    {
        // 必要であれば復元ロジックをここに記述
        return false; // デフォルトでは復元を許可しない
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Question $question): bool
    {
        // 必要であれば強制削除ロジックをここに記述
        return false; // デフォルトでは強制削除を許可しない
    }
}
