<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Answer;
use Illuminate\Auth\Access\Response;

class AnswerPolicy
{
    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Answer $answer): bool
    {
        // ユーザーが回答の所有者である場合に更新を許可
        return $user->id === $answer->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Answer $answer): bool
    {
        // ユーザーが回答の所有者である場合に削除を許可
        return $user->id === $answer->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Answer $answer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Answer $answer): bool
    {
        return false;
    }
}
