<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TenantScopeByAuthentication extends TenantScope
{
    public function apply(Builder $builder, Model $model)
    {
        $user = $this->getUser();

        if (! $user) {
            return;
        }

        $builder->where($model->qualifyColumn($this->getTenantId()), $user->tenant_id);
    }

    private function getUser()
    {
        $guards = config('auth.guards');

        foreach ($guards as $guard => $config) {
            if (Auth::guard($guard)->check()) {
                return Auth::guard($guard)->user();
            }
        }

        return null;
    }
}
