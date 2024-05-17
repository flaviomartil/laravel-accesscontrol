<?php

namespace flaviomartil\accesscontrol\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;
    use HasUuids;
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            config('accesscontrol.permission_model'),
            config('accesscontrol.permission_role_table'),
            config('accesscontrol.role_id_column'),
            config('accesscontrol.permission_id_column')
        );
    }
}
