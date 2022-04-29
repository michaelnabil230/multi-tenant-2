<?php

namespace App\Scopes;

use App\Traits\TenantIdColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

abstract class TenantScope implements Scope
{
    use TenantIdColumn;
    
    abstract public function apply(Builder $builder, Model $model);

    public function extend(Builder $builder)
    {
        $builder->macro('withoutTenancy', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }
}
