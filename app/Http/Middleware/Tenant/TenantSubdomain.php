<?php

namespace App\Http\Middleware\Tenant;

use App\Exceptions\NotFoundCustomException;
use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class TenantSubdomain
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = Str::of($request->getHost())->whenContains('.', fn (string $host) => Str::before($host, '.'));
        $tenant = Tenant::where('subdomain', '=', $host)->first();

        if ($tenant) {
            return $next($request);
        }

        throw new NotFoundCustomException(trans('custom.host', ['attribute' => $host]));
    }
}
