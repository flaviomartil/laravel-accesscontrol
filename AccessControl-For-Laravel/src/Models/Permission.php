<?php

namespace FlavioMartil\AccessControl\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends Model
{
    use HasUuids;

    protected $primaryKey = 'id';

    /**
     * Get the roles associated with the permission.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            config('accesscontrol.role_model'),
            config('accesscontrol.permission_role_table'),
            config('accesscontrol.permission_id_column'),
            config('accesscontrol.role_id_column')
        );
    }

    /**
     * Get the module associated with the permission.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(
            config('accesscontrol.module_model'),
            config('accesscontrol.module_id_column')
        );
    }
}
