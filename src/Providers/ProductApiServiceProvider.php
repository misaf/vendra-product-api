<?php

declare(strict_types=1);

namespace Misaf\VendraProductApi\Providers;

use Illuminate\Foundation\Console\AboutCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class ProductApiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('vendra-product-api');
    }

    public function packageBooted(): void
    {
        AboutCommand::add('Vendra Product API', fn() => ['Version' => 'dev-master']);
    }
}
