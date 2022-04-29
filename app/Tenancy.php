<?php

namespace App;

use App\Models\Tenant;

class Tenancy
{
    public Tenant $tenant;

    public bool $initialized = false;

    /**
     * Initializes the domain.
     *
     * @param string $column
     * 
     * @param string $value
     *
     * @return void
     */
    public function initialize($value): void
    {
        $tenant = Tenant::findBy($value);

        if ($this->initialized && $this->tenant->getTenantKey() === $tenant->getTenantKey()) {
            return;
        }

        if ($this->initialized) {
            $this->end();
        }

        $this->tenant = $tenant;

        event(new Events\InitializingTenancy($this));

        $this->initialized = true;

        event(new Events\TenancyInitialized($this));
    }

    public function end(): void
    {
        event(new Events\EndingTenancy($this));

        if (! $this->initialized) {
            return;
        }

        event(new Events\TenancyEnded($this));

        $this->initialized = false;

        $this->tenant = null;
    }
}
