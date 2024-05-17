<?php

namespace flaviomartil\accesscontrol\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasUuids;

    /**
     * Get the permissions associated with the module.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(
            config('accesscontrol.permission_model'),
            config('accesscontrol.module_id_column')
        );
    }
}
