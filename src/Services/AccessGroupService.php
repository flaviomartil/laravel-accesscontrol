<?php

namespace FlavioMartil\AccessControl\Services;

use Illuminate\Support\Str;

class AccessGroupService
{

    protected $roleModel;
    protected $permissionModel;

    public function __construct()
    {
        $this->roleModel = config('accesscontrol.role_model');
        $this->permissionModel = config('accesscontrol.permission_model');
    }

    public function getAccessGroup($id)
    {
        $permissions = $this->permissionModel::
        whereHas('module', function ($query) use ($id) {
            $query->where('module_id', $id);
        })->first();
        return $permissions;
    }

    public function getAccessGroups()
    {
        $permissions = $this->permissionModel::with('module')->get();
        return $permissions;
    }

    public function createAccessGroup($data)
    {
        $accessGroup = $this->roleModel::create([
            'id' => Str::uuid(),
            'code' => $data['code'],
            'name' => $data['name'],
        ]);
        return $accessGroup;
    }

    public function updateAccessGroup($uuid, $data)
    {
        $accessGroup = $this->roleModel::findOrFail($uuid);
        $accessGroup->update($data);

        if (isset($data['permissions'])) {
            $permissions = $this->permissionModel::whereIn('id', $data['permissions'])->get();
            $accessGroup->permissions()->sync($permissions);
        }

        return $accessGroup;
    }

    public function insertAccessGroupMembers($uuid, $associate)
    {
        $accessGroup = $this->roleModel::findOrFail($uuid);
        $permissions = $this->permissionModel::whereIn('id', $associate)->get();
        $accessGroup->permissions()->syncWithoutDetaching($permissions);
        return $accessGroup->permissions;
    }

    public function removeAccessGroupMembers($uuid, $deassociate)
    {
        $accessGroup = $this->roleModel::findOrFail($uuid);
        $accessGroup->permissions()->detach($deassociate);
        return $accessGroup->permissions;
    }

    public function bulkDeleteAccessGroups($ids)
    {
        $this->roleModel::destroy($ids);
        return ['status' => 'success'];
    }

    public function deleteAccessGroup($uuid)
    {
        $accessGroup = $this->roleModel::findOrFail($uuid);
        $accessGroup->delete();
        return ['status' => 'success'];
    }
}

?>