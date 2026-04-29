<?php

declare(strict_types=1);

namespace Misaf\VendraProductApi\JsonApi\V1\Products;

use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsToMany;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOne;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\Has;
use LaravelJsonApi\Eloquent\Filters\OnlyTrashed;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\WhereDoesntHave;
use LaravelJsonApi\Eloquent\Filters\WhereHas;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Filters\WhereIdNotIn;
use LaravelJsonApi\Eloquent\Filters\WhereIn;
use LaravelJsonApi\Eloquent\Filters\WhereNotIn;
use LaravelJsonApi\Eloquent\Filters\WithTrashed;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;
use Misaf\VendraApi\JsonApi\Filters\WhereHasInFilter;
use Misaf\VendraApi\JsonApi\Sorting\RandomPositionSort;
use Misaf\VendraProduct\Models\Product;

final class ProductSchema extends Schema
{
    public static string $model = Product::class;

    protected ?array $defaultPagination = ['number' => 1];

    public function fields(): array
    {
        return [
            ID::make(),
            Str::make('name'),
            Str::make('description'),
            Str::make('slug'),
            Number::make('token')
                ->readOnly(),
            Number::make('quantity'),
            Number::make('stock_threshold'),
            Boolean::make('in_stock'),
            Number::make('position')
                ->sortable()
                ->readOnly(),
            DateTime::make('available_soon')
                ->sortable(),
            DateTime::make('availability_date')
                ->sortable(),
            DateTime::make('created_at')
                ->sortable()
                ->readOnly(),
            DateTime::make('updated_at')
                ->sortable()
                ->readOnly(),
            HasOne::make('latestProductPrice')
                ->readOnly()
                ->type('product-prices'),
            BelongsToMany::make('multimedia')
                ->readOnly(),
            BelongsTo::make('productCategory')
                ->readOnly(),
            HasMany::make('productPrices')
                ->readOnly(),
        ];
    }

    public function filters(): array
    {
        return [
            WhereIdIn::make($this),
            WhereIdNotIn::make($this, 'exclude'),
            Where::make('product-category', 'product_category_id'),
            Where::make('search', 'name->fa')
                ->using('like'),
            Where::make('slug', 'slug->fa')
                ->singular(),
            WhereIn::make('in-slug', 'slug->fa'),
            WhereNotIn::make('not-in-slug', 'slug->fa'),
            Where::make('token')
                ->singular(),
            WhereIn::make('in-token', 'token'),
            WhereNotIn::make('not-in-token', 'token'),
            Where::make('quantity'),
            Where::make('gt-quantity', 'quantity')
                ->gt(),
            Where::make('gte-quantity', 'quantity')
                ->gte(),
            Where::make('lt-quantity', 'quantity')
                ->lt(),
            Where::make('lte-quantity', 'quantity')
                ->lte(),
            Where::make('stock-threshold'),
            Where::make('gt-stock-threshold', 'stock_threshold')
                ->gt(),
            Where::make('gte-stock-threshold', 'stock_threshold')
                ->gte(),
            Where::make('lt-stock-threshold', 'stock_threshold')
                ->lt(),
            Where::make('lte-stock-threshold', 'stock_threshold')
                ->lte(),
            Where::make('in_stock')
                ->asBoolean(),
            Where::make('available-soon')
                ->asBoolean(),
            Where::make('availability-date'),
            WhereHas::make($this, 'latestProductPrice', 'with-latest-product-price'),
            WhereDoesntHave::make($this, 'latestProductPrice', 'without-latest-product-price'),
            Has::make($this, 'multimedia', 'has-multimedia'),
            WhereHas::make($this, 'multimedia', 'with-multimedia'),
            WhereDoesntHave::make($this, 'multimedia', 'without-multimedia'),
            WhereHas::make($this, 'productCategory', 'with-product-category'),
            WhereHasInFilter::make($this, 'productCategory', 'with-in-product-category', 'slug->fa')->delimiter(','),
            WhereDoesntHave::make($this, 'productCategory', 'without-product-category'),
            WhereIn::make('in-product-category', 'product_category_id'),
            WhereNotIn::make('not-in-product-category', 'product_category_id'),
            Has::make($this, 'productPrices', 'has-product-prices'),
            WhereHas::make($this, 'productPrices', 'with-product-prices'),
            WhereDoesntHave::make($this, 'productPrices', 'without-product-prices'),
            WithTrashed::make('with-trashed'),
            OnlyTrashed::make('trashed'),
        ];
    }

    public function includePaths(): iterable
    {
        return [
            'latestProductPrice',
            'multimedia',
            'productCategory',
            'productPrices',
        ];
    }

    public function pagination(): PagePagination
    {
        return PagePagination::make();
    }

    public function sortables(): iterable
    {
        return [
            RandomPositionSort::make('random-position'),
        ];
    }
}
