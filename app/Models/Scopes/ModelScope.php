<?php

namespace App\Models\Scopes;

use App\Tenant\ManagerTenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ModelScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $tenantId = app(ManagerTenant::class)->identify();
        $builder->where('tenant_id', '=', $tenantId);
    }
}
