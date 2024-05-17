<?php

namespace App\Services\GroupAccess;

use Illuminate\Support\Facades\Gate;
use App\Models\GroupAccess\Permission;

class PermissionService
{
    public static function registerGates()
    {
        // Carrega permissões específicas do tenant
        $permissions = Permission::with('module')->get();

        // Registra Gates para as permissões
        foreach ($permissions as $permission) {
            Gate::define($permission->name, function ($user) use ($permission) {
                return $user->hasPermissionTo($permission->name);
            });
        }
    }
}
