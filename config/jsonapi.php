<?php

declare(strict_types=1);

use Misaf\VendraMultimediaApi\JsonApi\V1\Server as MultimediaServer;
use Misaf\VendraProductApi\JsonApi\V1\Server as ProductServer;

return [
    'namespace' => 'JsonApi',

    'servers' => [
        'vendra-multimedia' => MultimediaServer::class,
        'vendra-product'    => ProductServer::class,
    ],
];
