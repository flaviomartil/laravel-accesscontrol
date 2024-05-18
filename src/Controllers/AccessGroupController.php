<?php

namespace FlavioMartil\AccessControl\Controllers;

use FlavioMartil\AccessControl\Controllers\Controller;
use Illuminate\Http\Request;
use FlavioMartil\AccessControl\Services\AccessGroupService;

class AccessGroupController extends Controller
{
    protected $accessGroupService;

    public function __construct(AccessGroupService $accessGroupService)
    {
        $this->accessGroupService = $accessGroupService;
    }

    public function getAccessGroups()
    {
        return response()->json($this->accessGroupService->getAccessGroups());
    }

    public function setAccessGroups(Request $request)
    {
        $roleId = $request->input('role_id');
        $permissionIds = $request->input('permission_ids');

        return response()->json($this->accessGroupService->setAccessGroups($roleId, $permissionIds));
    }

    public function deleteAccessGroups(Request $request)
    {
        $roleId = $request->input('role_id');
        $permissionId = $request->input('permission_id');

        $this->accessGroupService->deleteAccessGroups($roleId, $permissionId);

        return response()->json(['status' => 'success']);
    }
}