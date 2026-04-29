<?php

declare(strict_types=1);

namespace Misaf\VendraProductApi\JsonApi\V1\ProductPrices;

use LaravelJsonApi\Core\Resources\JsonApiResource;

final class ProductPriceResource extends JsonApiResource
{
    public function attributes($request): iterable
    {
        return [
            'price'      => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function relationships($request): iterable
    {
        return [
            $this->relation('currency'),
            $this->relation('product'),
        ];
    }
}
