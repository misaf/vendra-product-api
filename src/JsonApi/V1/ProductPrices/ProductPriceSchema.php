<?php

declare(strict_types=1);

namespace Misaf\VendraProductApi\JsonApi\V1\ProductPrices;

use LaravelJsonApi\Eloquent\Fields\ArrayHash;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
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
use Misaf\VendraProduct\Models\ProductPrice as ModelsProductPrice;

final class ProductPriceSchema extends Schema
{
    public static string $model = ModelsProductPrice::class;

    protected ?array $defaultPagination = ['number' => 1];

    public function fields(): array
    {
        return [
            ID::make(),
            ArrayHash::make('price'),
            DateTime::make('created_at')
                ->sortable()
                ->readOnly(),
            DateTime::make('updated_at')
                ->sortable()
                ->readOnly(),
            BelongsTo::make('product')
                ->readOnly(),
            BelongsTo::make('currency')
                ->readOnly(),
        ];
    }

    public function filters(): array
    {
        return [
            WhereIdIn::make($this),
            WhereIdNotIn::make($this, 'exclude'),
            Where::make('product', 'product_id'),
            Where::make('currency', 'currency_id'),
            WhereHas::make($this, 'product', 'with-product'),
            WhereDoesntHave::make($this, 'product', 'without-product'),
            WhereIn::make('in-product', 'product_id'),
            WhereNotIn::make('not-in-product', 'product_id'),
            WhereHas::make($this, 'currency', 'with-currency'),
            WhereDoesntHave::make($this, 'currency', 'without-currency'),
            WhereIn::make('in-currency', 'currency_id'),
            WhereNotIn::make('not-in-currency', 'currency_id'),
            WithTrashed::make('with-trashed'),
            OnlyTrashed::make('trashed'),
        ];
    }

    public function includePaths(): iterable
    {
        return [
            'currency',
            'product',
        ];
    }

    public function pagination(): PagePagination
    {
        return PagePagination::make();
    }
}
