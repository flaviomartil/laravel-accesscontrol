<?php

use Illuminate\Support\Facades\Route;
use FlavioMartil\AccessControl\Controllers\AccessGroupController;


Route::group(['prefix' => 'access-groups'], function () {
    Route::post('/', [AccessGroupController::class, 'createAccessGroup']);
    Route::put('/{uuid}', [AccessGroupController::class, 'updateAccessGroup']);
    Route::patch('/{uuid}/insert', [AccessGroupController::class, 'insertAccessGroupMembers']);
    Route::patch('/{uuid}/remove', [AccessGroupController::class, 'removeAccessGroupMembers']);
    Route::delete('/', [AccessGroupController::class, 'bulkDeleteAccessGroups']);
    Route::delete('/{uuid}', [AccessGroupController::class, 'deleteAccessGroup']);
    Route::get('/', [AccessGroupController::class, 'getAccessGroups']);
    Route::get('/{uuid}', [AccessGroupController::class, 'getAccessGroup']);
});
