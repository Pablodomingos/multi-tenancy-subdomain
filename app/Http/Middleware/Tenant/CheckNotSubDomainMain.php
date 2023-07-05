<?php

namespace App\Http\Middleware\Tenant;

use App\Exceptions\ForbiddenCustomException;
use App\Tenant\ManagerTenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckNotSubDomainMain
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     *
     * @throws ForbiddenCustomException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $managerTenant = app(ManagerTenant::class);

        if ($managerTenant->isSubDomainMain()) {
            throw new ForbiddenCustomException(__('custom.subdomain_invalid'), Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
