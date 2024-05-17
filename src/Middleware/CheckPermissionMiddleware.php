<?php

namespace FlavioMartil\AccessControl\Middleware;

use Closure;
use FlavioMartil\AccessControl\Exceptions\Exceptions\AccessControlException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermissionMiddleware
{
    public function handle($request, Closure $next, $permission)
    {
        if (config('accesscontrol.tenant.use_tenant')) {
            $tenantModel = config('accesscontrol.tenant.tenant_identifier_model');
            $tenantKey = config('accesscontrol.tenant.tenant_key');
            $tenant = optional(app($tenantModel))->getAttribute($tenantKey) ?? null;

            if (!$tenant) {
                throw AccessControlException::tenancyLoad()->setStatusCode(Response::HTTP_NOT_FOUND);
            }

        }
        $user = Auth::guard('api')->user() ?? auth()->user();

        $userPermissions = $user->permissions()->pluck('name')->toArray();

        if (!in_array($permission, $userPermissions)) {
            throw AccessControlException::accessDenied()->setStatusCode(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
