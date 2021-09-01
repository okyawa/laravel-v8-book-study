<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Testing\Fakes\MailFake;
use Tests\TestCase;

/**
 * コンポーネントのモック (Fake) - Mailのモッククラスを活用
 *
 * フレームワークが提供するMail、Event、Notification、Bus、Queue、Storageには、
 * それぞれコンポーテントと同じAPIを持つモッククラスが用意されている
 *
 * Mailのモッククラスを利用するには、Mailファサードのfakeメソッドを利用する
 * fakeメソッドを実行すると、サービスコンテナに登録されているインスタンスがモックに置き換わる
 * これでMailファサードや対応インスタンスをDIで取得した箇所では、モッククラスを利用することになる
 *
 * 具体的には、Mailファサードでは Illuminate\Support\Testing\Fakes\MailFake クラスがモッククラス
 * MailFakeにはアサーションが用意されているので、これを利用して送信内容を検証可能
 *
 * このファイルの生成コマンド
 * $ php artisan make:test Api/MailTest
 *
 * 9-3-4
 */
class MailTest extends TestCase
{
    /**
     * MailFakeのアサーションメソッド
     *
     * assertNotSent        指定されたメールが送信されていないことを検証
     * assertNothingSent    メールが送信されていないことを検証
     * assertQueued         指定されたメールがメールキューに登録されたことを検証
     * assertNotQueued      指定されたメールがメールキューに登録されていないことを検証
     * assertNothingQueued  メールキューに登録されていないことを検証
     *
     * 表 9.3.4.6
     */

    /**
     * ファサードのfakeメソッドを利用した例
     *
     * assetSentメソッドの引数によって動作が変わる
     *
     * 第1引数に送信されたIlluminate\Mail\Mailableインターフェースを実装したクラス名を指定し、
     * 第2引数に数値を指定すると、送信された件数を検証する
     *
     * 第1引数にクロージャのようなcallable型の値を指定すると、
     * この値の実行結果によって検証が成功したかどうかを示す
     * 検証が成功した場合はtrueを、そうでない場合はfalseを戻り値として返す
     *
     * リスト 9.3.4.8
     *
     * @test
     */
    public function Mailファサードfakeを利用したテスト()
    {
        Mail::fake(); // MailFakeに置き換え

        $response = $this->postJson(
            '/api/send-email',
            [
                'to' => 'a@example.com',
            ]
        );

        $response->assertStatus(200);

        // MailFakeを利用したアサーション
        // Sampleクラスのインスタンスを1件送信したことを検証
        Mail::assertSent(Sample::class, 1);
        // 送信した$mailableの値を検証
        // 指定したメールアドレスにメールが送信されたことを検証
        Mail::assertSent(function (Mailable $mailable) {
            return $mailable->hasTo('a@example.com');
        });
    }

    /**
     * @test
     */
    public function Mailファサードfakeを利用したテスト_DI()
    {
        Mail::fake();

        $response = $this->postJson(
            '/api/send-email',
            [
                'to' => 'a@example.com',
            ]
        );

        $response->assertStatus(200);

        Mail::assertSent(Sample::class, 1);
        Mail::assertSent(
            Sample::class,
            function (Mailable $mailable) {
                return $mailable->hasTo('a@example.com');
            }
        );
    }

    /**
     * @test
     */
    public function post_send_mail()
    {
        $response = $this->postJson(
            '/api/send-email',
            [
                'to' => 'a@example.com',
            ]
        );

        $response->assertStatus(200);
        $response->assertExactJson(['ok']);
    }

    /**
     * @test
     */
    public function MailFakeを利用したテスト()
    {
        $fakerMailer = new MailFake();
        $this->app->singleton(
            'mailer',
            function () use ($fakerMailer) {
                return $fakerMailer;
            }
        );

        $response = $this->postJson(
            '/api/send-email',
            [
                'to' => 'a@example.com',
            ]
        );

        $response->assertStatus(200);

        $fakerMailer->assertSent(Sample::class, 1);
        $fakerMailer->assertSent(
            Sample::class,
            function (Mailable $mailable) {
                return $mailable->hasTo('a@example.com');
            }
        );
    }
}
