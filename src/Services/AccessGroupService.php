<?php

namespace FlavioMartil\AccessControl\Services;
class AccessGroupService
{
    public function getAccessGroups()
    {
        $permissionModel = config('accesscontrol.permission_model');
        $permissions = $permissionModel::with('module')->get();
        return $permissions;
    }

    public function setAccessGroups($roleId, $permissionIds)
    {
        $roleModel = config('accesscontrol.role_model');
        $permissionModel = config('accesscontrol.permission_model');

        $role = $roleModel::findOrFail($roleId);
        $permissions = $permissionModel::whereIn('id', $permissionIds)->get();

        $role->permissions()->syncWithoutDetaching($permissions);

        return $role->permissions;
    }

    public function deleteAccessGroups($roleId, $permissionId)
    {
        $roleModel = config('accesscontrol.role_model');
        $role = $roleModel::findOrFail($roleId);
        $role->permissions()->detach($permissionId);

        return true;
    }
}

?>