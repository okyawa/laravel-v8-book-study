<?php

/**
 * elasticsearch/elasticsearch利用のための設定値記入例
 *
 * リスト7.3.6.3
 */

return [
    'hosts' => [
        // Elasticsearchのhostを環境に合わせて指定
        env('ELASTICSEARCH_HOST', '127.0.0.1:9200'),
    ]
];
