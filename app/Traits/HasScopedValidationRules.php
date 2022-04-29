<?php

namespace App\Traits;

use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;

trait HasScopedValidationRules
{
    use TenantIdColumn;

    public function unique($table, $column = 'NULL')
    {
        return (new Unique($table, $column))->where($this->getTenantId(), $this->getTenantKey());
    }

    public function exists($table, $column = 'NULL')
    {
        return (new Exists($table, $column))->where($this->getTenantId(), $this->getTenantKey());
    }
}
