<?php

namespace App\Tenant;

use App\Models\Tenant;
use Illuminate\Support\Str;

class ManagerTenant
{
    public function __construct(
        private readonly Tenant $tenant
    )
    {
    }

    public function subdomain(): ?string
    {
        return Str::of(request()->getHost())->whenContains('.', fn (string $host) => Str::before($host, '.'));
    }

    public function tenant(): ?Tenant
    {
        return $this->tenant->where('subdomain', '=', $this->subdomain())->first();
    }

    public function identify(): int|string|null
    {
        return $this->tenant()->id;
    }
}
