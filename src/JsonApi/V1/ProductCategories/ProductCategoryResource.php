<?php

declare(strict_types=1);

namespace Misaf\VendraProductApi\JsonApi\V1\ProductCategories;

use App\Traits\LocalizableAttributesTrait;
use LaravelJsonApi\Core\Resources\JsonApiResource;

final class ProductCategoryResource extends JsonApiResource
{
    use LocalizableAttributesTrait;

    public function attributes($request): iterable
    {
        return [
            'name'        => $this->name,
            'description' => $this->description,
            'slug'        => $this->slug,
            'position'    => $this->position,
            'status'      => $this->status,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }

    public function relationships($request): iterable
    {
        return [
            $this->relation('multimedia'),
            $this->relation('productPrices'),
            $this->relation('products'),
        ];
    }
}
