<?php

declare(strict_types=1);

namespace App\UseCases;

use App\Events\PublishProcessor;
use App\Models\User;
use Illuminate\Support\Facades\Event;

/**
 * イベント発火キャンセル
 *
 * 特定の条件下で、イベントに紐付くリスナーの処理を実行させたくない場合は、
 * forgetメソッド対象のイベントを指定することでリスナーの起動をキャンセルできる
 * hasListenerメソッドは指定したイベントに紐付いたリスナーがあるかどうかを論理型で返却
 *
 * リスト 7.1.4.1
 */
class UsePurchasedBook
{
    const DISABLE_NOTIFICATION = 1;

    /**
     * 購入処理でユーザーステータスを条件にイベントをキャンセルする処理
     * リスナーが削除されるため、dispatchメソッドをコールしてもリスナーの処理は実行されない
     */
    public function run(User $customer)
    {
        if ($customer->getStatus() === self::DISABLE_NOTIFICATION) {
            if (Event::hasListeners(PublishProcessor::class)) {
                Event::forget(PublishProcessor::class);
            }
        }
        Event::dispatch(new PublishProcessor($customer->getId()));
    }
}
