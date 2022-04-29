<?php

namespace App\Events\Contracts;

use App\Tenancy;

abstract class TenancyEvent
{
    /** @var Tenancy */
    public $tenancy;

    public function __construct(Tenancy $tenancy)
    {
        $this->tenancy = $tenancy;
    }
}
