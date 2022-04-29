<?php

namespace App\Traits;

trait TenantIdColumn
{
    static $tenantIdColumn = 'tenant_id';

    public function getTenantId(): string
    {
        return TenantIdColumn::$tenantIdColumn;
    }
}
