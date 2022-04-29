<?php

use App\Models\Tenant;
use App\Tenancy;

if (! function_exists('tenancy')) {
    /** @return Tenancy */
    function tenancy()
    {
        return app(Tenancy::class);
    }
}

if (! function_exists('tenant')) {
    /**
     * Get a key from the current tenant's storage.
     *
     * @param string|null $key
     * @return Tenant|null|mixed
     */
    function tenant($key = null)
    {
        if (! app()->bound(Tenant::class)) {
            return;
        }

        if (is_null($key)) {
            return app(Tenant::class);
        }

        return optional(app(Tenant::class))->getAttribute($key) ?? null;
    }
}
