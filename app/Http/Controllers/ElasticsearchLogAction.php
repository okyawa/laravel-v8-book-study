<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\UserResourceException;
use function logs;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;

/**
 * アクセスログをElasticsearchに送信する
 *
 * このファイルの生成コマンド
 * $ php artisan make:controller ElasticsearchLogAction
 *
 * リスト 10.2.3.5
 */
final class ElasticsearchLogAction extends Controller
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Request $request)
    {
        throw new UserResourceException('error');
        $this->logger
            ->driver('elasticsearch')
            ->info(
                'user.action',
                [
                    'uri' => $request->getUri(),
                    'referer' => $request->headers->get('referer', ''),
                    'user_id' => 1,
                    'query' => $request->query->all()
                ]
            );
        // Logファサード、またはlogsヘルパー関数も利用可能
        logs('elasticsearch')->info(
            'user.action',
            [
                'uri' => $request->getUri(),
                'referer' => $request->headers->get('referer', ''),
                'user_id' => 1,
                'query' => $request->query->all()
            ]
        );
    }
}
