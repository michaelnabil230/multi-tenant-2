<?php

namespace App\Traits;

use App\Models\Tenant;
use App\Traits\TenantIdColumn;
use App\Scopes\TenantScopeByInitialized;
use App\Scopes\TenantScopeByAuthentication;

trait BelongsToTenant
{
    use TenantIdColumn;

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, $this->getTenantId());
    }

    public static function bootBelongsToTenant()
    {
        $scope = (new self)->getScopeTenant();

        static::addGlobalScope(new $scope);

        static::creating(function ($model) {
            if (!$model->getAttribute($this->getTenantId()) && !$model->relationLoaded('tenant')) {
                if (tenancy()->initialized != null) {
                    $model->setAttribute($this->getTenantId(), tenant()->getTenantKey());
                    $model->setRelation('tenant', tenant());
                }
            }
        });
    }

    public function getScopeTenant()
    {
        return $this->scopeTenant ?? tenancy()->initialized
            ? TenantScopeByInitialized::class
            : TenantScopeByAuthentication::class;
    }
}
