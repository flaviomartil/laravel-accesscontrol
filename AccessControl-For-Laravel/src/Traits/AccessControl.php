<?php

namespace FlavioMartil\AccessControl\Traits;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait AccessControl
{
    /**
     * Retrieve the roles associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            config('accesscontrol.role_model'),
            config('accesscontrol.group_access_table'),
            config('accesscontrol.user_id_column'),
            config('accesscontrol.role_id_column')
        );
    }

    /**
     * Retrieve the permissions associated with the user through roles.
     *
     * @return \Illuminate\Support\Collection
     */
    public function permissions()
    {
        return $this->roles()->with('permissions')->get()->pluck('permissions')->flatten()->unique('id');
    }

    /**
     * Retrieve the modules associated with the user through roles.
     *
     * @return \Illuminate\Support\Collection
     */
    public function modules()
    {
        return $this->permissions()->map(function ($permission) {
            return $permission->module;
        })->unique('id');
    }

    /**
     * Assigns a given role to the user.
     *
     * @param string $roleName
     * @return bool
     */
    public function assignRole($roleName)
    {
        $roleModel = config('accesscontrol.role_model');
        $role = $roleModel::where('name', $roleName)->first();

        if ($role) {
            $this->roles()->attach($role);
            return true;
        }

        return false;
    }

    /**
     * Check if the user has a given role.
     *
     * @param string $roleName
     * @return bool
     */
    public function hasRole($roleName)
    {
        return $this->roles->contains('name', $roleName);
    }


    /**
     * Get access details (roles and permissions) of the user.
     *
     * @return array
     */
    public function getAccessDetails(): array
    {
        $roles = $this->roles;
        $modules = $this->modules();
        $permissions = $this->permissions();

        $accessDetails = [
            'roles' => $roles->pluck('name'),
            'modules' => $modules->mapWithKeys(function ($module) {
                return [
                    $module->name => [
                        'permissions' => $module->permissions->pluck('name')
                    ]
                ];
            }),
        ];

        return $accessDetails;
    }
}
