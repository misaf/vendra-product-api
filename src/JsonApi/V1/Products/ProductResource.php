<?php

declare(strict_types=1);

namespace Misaf\VendraProductApi\JsonApi\V1\Products;

use App\Traits\LocalizableAttributesTrait;
use LaravelJsonApi\Core\Resources\JsonApiResource;

final class ProductResource extends JsonApiResource
{
    use LocalizableAttributesTrait;

    public function attributes($request): iterable
    {
        return [
            'name'              => $this->name,
            'description'       => $this->description,
            'slug'              => $this->slug,
            'token'             => $this->token,
            'quantity'          => $this->quantity,
            'stock_threshold'   => $this->stock_threshold,
            'in_stock'          => $this->in_stock,
            'position'          => $this->position,
            'available_soon'    => $this->available_soon,
            'availability_date' => $this->availability_date,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }

    public function relationships($request): iterable
    {
        return [
            $this->relation('latestProductPrice'),
            $this->relation('multimedia'),
            $this->relation('productCategory'),
            $this->relation('productPrices'),
        ];
    }
}
