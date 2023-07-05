<?php

namespace App\Http\Middleware\Tenant;

use App\Exceptions\NotFoundCustomException;
use App\Tenant\ManagerTenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantSubdomain
{
    /**
     * @throws NotFoundCustomException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $tenant = app(ManagerTenant::class)->tenant();

        if ($tenant) {
            return $next($request);
        }

        throw new NotFoundCustomException(__('custom.host'));
    }
}
