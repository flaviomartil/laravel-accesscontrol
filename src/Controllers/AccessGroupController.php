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

    public function getAccessGroup($id)
    {
        return response()->json($this->accessGroupService->getAccessGroup($id));
    }

    public function getAccessGroups()
    {
        return response()->json($this->accessGroupService->getAccessGroups());
    }

    public function createAccessGroup(Request $request)
    {
        $data = $request->only(['code', 'name']);
        return response()->json($this->accessGroupService->createAccessGroup($data));
    }


    public function updateAccessGroup(Request $request, $uuid)
    {
        $data = $request->only(['id', 'code', 'permissions']);
        return response()->json($this->accessGroupService->updateAccessGroup($uuid, $data));
    }

    public function insertAccessGroupMembers(Request $request, $uuid)
    {
        $associate = $request->input('associate');
        return response()->json($this->accessGroupService->insertAccessGroupMembers($uuid, $associate));
    }

    public function removeAccessGroupMembers(Request $request, $uuid)
    {
        $deassociate = $request->input('deassociate');
        return response()->json($this->accessGroupService->removeAccessGroupMembers($uuid, $deassociate));
    }

    public function bulkDeleteAccessGroups(Request $request)
    {
        $ids = $request->input('ids');
        return response()->json($this->accessGroupService->bulkDeleteAccessGroups($ids));
    }

    public function deleteAccessGroup($uuid)
    {
        return response()->json($this->accessGroupService->deleteAccessGroup($uuid));
    }
}