<?php

namespace App\Listeners;

use App\Jobs\SendRegistMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;

class RegisteredListener
{
    private $mailer;
    private $eloquent;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mailer, User $eloquent)
    {
        $this->mailer = $mailer;
        $this->eloquent = $eloquent;
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $user = $this->eloquent->findOrFail($event->user->getAuthIdentifier());
        $this->mailer->raw('会員登録完了しました', function ($message) use ($user) {
            $message->subject('会員登録メッセージ')->to($user->email);
        });

        /**
         * ジョブキュー指定
         *
         * default以外のキューを指定する場合は、--queueオプションを利用してqueueを指定
         *
         * キューの起動コマンド
         * $ php artisan queue:work --queue mail
         *
         * リスト 7.2.6.3
         */
        dispatch(new SendRegistMail($event->user->email))
            ->onQueue('mail')
            ->delay(now()->addHour(1));
    }
}

