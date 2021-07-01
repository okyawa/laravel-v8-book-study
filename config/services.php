<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /**
     * GitHub OAuth認証を利用する例
     *
     * GitHubのOAuthを利用する場合
     * GitHubの [setting]→[Developers settings] に遷移し、
     * [OAuth Apps]の[New OAuth APP] でアプリケーションを登録
     * リスト 6.4.2.1
     */
    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => 'http://localhost/register/callback',
    ],

    /**
     * Amazon OAuth認証を利用する例
     *
     * AmazonのOAuth認証を利用するには、
     * [Login with Amazon]の[Developer Center]→[Getting Started]から[Web]を選択
     * https://login.amazon.com/website
     * [Register new application]で利用するアプリケーションを登録
     * 登録すると、ClientIDとClientSecretが発行される
     */
    'amazon' => [
        'client_id' => env('AMAZON_CLIENT_ID'),
        'client_secret' => env('AMAZON_CLIENT_SECRET'),
        'redirect' => 'http://localhost/register/callback',
    ],
];
