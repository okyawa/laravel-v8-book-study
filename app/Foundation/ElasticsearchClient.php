<?php

declare(strict_types=1);

namespace App\Foundation;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

/**
 * ElasticsearchClientクラス実装例
 *
 * リスト 7.3.6.2
 */
class ElasticsearchClient
{
    protected $hosts = [];

    public function __construct(array $hosts)
    {
        $this->hosts = $hosts;
    }

    public function client(): Client
    {
        return ClientBuilder::create()->setHosts($this->hosts)
            ->build();
    }
}
