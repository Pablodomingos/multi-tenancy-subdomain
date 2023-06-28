<?php

namespace App\Observers;

use App\Tenant\ManagerTenant;
use Illuminate\Database\Eloquent\Model;

class ModelObserver
{
    public function creating(Model $model): void
    {
        $tenantId = app(ManagerTenant::class)->identify();
        $model->setAttribute('tenant_id', $tenantId);
    }
}
