<?php

namespace App\Policies;

use App\Models\Content;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Eloquentモデルが記述されたメソッドを含むポリシークラス作成例
 *
 * リスト 6.5.2.7
 * ポリシークラスは、特定のEloquentモデルと紐付いているわけではない
 * データの新規作成、削除、表示など、コントローラの処理と関連するEloquentモデルを型宣言として、
 * いくつかのメソッドが記述されたクラスの雛形も生成できる
 * 雛形が必要な場合は、下記コマンドのように、make:policyコマンドに--modelオプションで、対応するEloquentモデルを指定
 *
 * $ php artisan make:policy ContentPolicy --model=Content
 */

/**
 * Eloquentモデルが記述されたメソッドを含むポリシークラス (雛形あり)
 *
 * 各メソッドとコントローラを対応させて利用することで、どういう処理が実行されるか用意に把握可能にある
 * ポリシークラスのメソッド名に命名規則はなく、自由にメソッド名を記述できる
 * beforeメソッドをポリシークラスに記述することで、ポリシークラスのメソッドが実行される前にbeforeメソッドが実行される
 * リスト 6.5.2.8
 */
class ContentPolicyWithScaffold
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Content  $content
     * @return mixed
     */
    public function view(User $user, Content $content)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Content  $content
     * @return mixed
     */
    public function update(User $user, Content $content)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Content  $content
     * @return mixed
     */
    public function delete(User $user, Content $content)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Content  $content
     * @return mixed
     */
    public function restore(User $user, Content $content)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Content  $content
     * @return mixed
     */
    public function forceDelete(User $user, Content $content)
    {
        //
    }
}
