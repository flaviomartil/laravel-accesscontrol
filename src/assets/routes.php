<?php

use Illuminate\Support\Facades\Route;
use FlavioMartil\AccessControl\Controllers\AccessGroupController;

Route::get('/get-access-groups', [AccessGroupController::class, 'getAccessGroups']);
Route::put('/set-access-groups', [AccessGroupController::class, 'setAccessGroups']);
Route::delete('/delete-access-groups', [AccessGroupController::class, 'deleteAccessGroups']);
