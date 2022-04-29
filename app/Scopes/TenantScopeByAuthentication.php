<?php

namespace App\Scopes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TenantScopeByAuthentication extends TenantScope
{
    public function apply(Builder $builder, Model $model)
    {
        $user = $this->getUser();

        if (!$user) {
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
