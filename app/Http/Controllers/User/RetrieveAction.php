<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\Request;
use stdClass;

final class RetrieveAction extends Controller
{
    private $authManager;
    private $gate;

    public function __construct(
        AuthManager $authManager,
        Gate $gate
    ) {
        $this->authManager = $authManager;
        $this->gate = $gate;
    }

    public function __invoke(Request $request, string $id)
    {
        /**
         * PHPビルトインクラスを使ったポリシークラスの利用例
         *
         * ビルトインクラスのインスタンスにidpプロパティに値を与え、
         * ログインユーザーとビルトインクラスのインスタンスをポリシークラスのeditメソッドを利用
         * リスト 6.5.2.13
         */
        $class = new stdClass();
        $class->id = 1;
        $this->gate->forUser(
            $this->authManager->guard()->user()
        )->allows('edit', $class);

        /**
         * AuthorizesRequestsトレイトのメソッド利用例
         *
         * App\Http\Controllers\Controllerクラスでは、Illuminate\Foundation\Auth\Access\AuthorizesRequestsトレイトを通じて、
         * 認可処理をかんたんに扱えるメソッドを利用できる
         * authorizeForUserメソッドは、認可されていない場合はエラーとして、Illuminate\Auth\Access\AuthorizationExceptionがスローされる
         * 認可される条件の場合は処理を通過して、以降の処理が実行される
         * リスト 6.5.2.14
         */
        $class = new stdClass();
        $class->id = 1;
        $this->authorizeForUser(
            $this->authManager->guard()->user(),
            'edit',
            $class
        );

        /**
         * 認可処理の適用例
         *
         * Gateのdefineメソッドで記述した処理が実行される
         * プロフィールを表示するURL、/user/{id}にアクセスした場合、ログインしているユーザーIDと同一であれば、何らかの処理を実行
         * allowsメソッドとは逆のdeniesメソッドを使用すると、認可されていない場合に作用できる
         * Gateを利用する場合は、内部で認証済みユーザーを取得するようになっているので、ミドルフェアで認証を利用するように予め設定する必要あり
         * defineメソッドの第2引数にはクロージャの他に、ルートの登録と同様のクラス名@メソッド名を記述する方法や、
         * Laravelのリソースコントローラと同じく特定メソッドを含んだクラスを指定することで、
         * 複数の認可処理を記述したアクセスポリシークラスを登録する方法がある
         * リスト6.5.2.2
         */
        if ($this->gate->allows('user-access', $id)) {
            // 実行が許可される場合に実行
        }
        // または
        // \Gate::allows('user-access', $id);

        /**
         * Eloquentモデル経由の認可処理実行例
         *
         * リスト6.5.2.10
         */
        $content = Content::find((int) $id);
        /** @var User $user */
        $user = $this->authManager->guard()->user();
        if ($user->can('update', $content)) {
            // 実行可能な場合処理される
        }

        /**
         * ユーザー情報を返却するコントローラクラス
         *
         * jwtドライバを介したユーザー情報アクセス例
         * リスト 6.3.4.5
         */
        return $this->authManager->guard('jwt')->user();

        /**
         * Illuminate\Http\RequestクラスのbearerTokenメソッドを利用すると、
         * Authorization: Bearerヘッダで送信された値を取得できるため、
         * 下記の方法でもOK
         *
         * リスト 6.3.4.6
         */
        // $this->authManager->setToken($request->bearerToken()->user());
    }

    /**
     * ユーザー情報返却例
     *
     * リスト 6.3.4.7
     */
    /*
    {
        "id": 1,
        "name": "laravel user",
        "email": "mail@example.com",
        "created_at": "2018-08-05: 20:44:05",
        "updated_at": null
    }
    */
}
