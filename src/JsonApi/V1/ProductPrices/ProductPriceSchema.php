<?php

declare(strict_types=1);

namespace Misaf\VendraProductApi\JsonApi\V1\ProductPrices;

use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\Has;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\WhereDoesntHave;
use LaravelJsonApi\Eloquent\Filters\WhereHas;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Filters\WhereIdNotIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;
use Misaf\VendraProduct\Models\ProductPrice;

final class ProductPriceSchema extends Schema
{
    public static string $model = ProductPrice::class;

    protected ?array $defaultPagination = ['number' => 1];

    public function fields(): array
    {
        return [
            ID::make(),

            Str::make('currency_code'),

            Number::make('price')
                ->sortable(),

            DateTime::make('created_at')
                ->sortable()
                ->readOnly(),

            DateTime::make('updated_at')
                ->sortable()
                ->readOnly(),

            BelongsTo::make('product')
                ->readOnly(),

            BelongsTo::make('productCategory')
                ->readOnly(),
        ];
    }

    public function filters(): array
    {
        return [
            ...$this->getPrimaryKeyFilters(),
            ...$this->getAttributeFilters(),
            ...$this->getRelationFilters(),
        ];
    }

    private function getPrimaryKeyFilters(): array
    {
        return [
            WhereIdIn::make($this),
            WhereIdNotIn::make($this, 'exclude'),
        ];
    }

    private function getAttributeFilters(): array
    {
        return [
            Where::make('currency_code'),

            Where::make('price')
                ->asInteger(),

            Where::make('gt-price', 'price')
                ->asInteger()
                ->gt(),

            Where::make('gte-price', 'price')
                ->asInteger()
                ->gte(),

            Where::make('lt-price', 'price')
                ->asInteger()
                ->lt(),

            Where::make('lte-price', 'price')
                ->asInteger()
                ->lte(),
        ];
    }

    private function getRelationFilters(): array
    {
        return [
            WhereHas::make($this, 'product', 'with-product'),
            WhereDoesntHave::make($this, 'product', 'without-product'),

            WhereHas::make($this, 'productCategory', 'with-product-category'),
            WhereDoesntHave::make($this, 'productCategory', 'without-product-category'),

            Has::make($this, 'multimedia', 'has-multimedia'),
            WhereHas::make($this, 'multimedia', 'with-multimedia'),
            WhereDoesntHave::make($this, 'multimedia', 'without-multimedia'),
        ];
    }

    public function includePaths(): iterable
    {
        return [
            'product',
            'productCategory',
        ];
    }

    public function pagination(): PagePagination
    {
        return PagePagination::make();
    }
}
