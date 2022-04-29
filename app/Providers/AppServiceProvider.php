<?php

namespace App\Providers;

use App\Traits\TenantIdColumn;
use App\Events\TenancyInitialized;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        TenantIdColumn::$tenantIdColumn = 'tenant_id';

        Blueprint::macro('tenant', function () {
            $this->foreignUuid(TenantIdColumn::$tenantIdColumn)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
        Blueprint::macro('dropTenant', function () {
            $this->dropConstrainedForeignId(TenantIdColumn::$tenantIdColumn);
        });

        Event::listen(TenancyInitialized::class, function (TenancyInitialized $event) {
            // PermissionRegistrar::$cacheKey = 'spatie.permission.cache.tenant.' . $event->tenancy->tenant->id;
            // DatabaseSettingStore::$cacheKey = 'setting.cache.tenant.' . $event->tenancy->tenant->id;
        });

        \App\Http\Middleware\InitializeTenancy::$onFail = function ($request, $next) {
            return redirect(config('app.url'));
        };
    }
}
