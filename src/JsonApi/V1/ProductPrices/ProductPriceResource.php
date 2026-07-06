<?php

declare(strict_types=1);

namespace Misaf\VendraProductApi\JsonApi\V1\ProductPrices;

use LaravelJsonApi\Core\Resources\JsonApiResource;
use Misaf\VendraProduct\Models\ProductPrice;

/**
 * @mixin ProductPrice
 */
final class ProductPriceResource extends JsonApiResource
{
    /**
     * @return iterable<string, mixed>
     */
    public function attributes($request): iterable
    {
        return [
            'currency_code' => $this->currency_code,
            'price'         => $this->price,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }

    /**
     * @return iterable<int, mixed>
     */
    public function relationships($request): iterable
    {
        return [
            $this->relation('product'),
            $this->relation('productCategory'),
        ];
    }
}
