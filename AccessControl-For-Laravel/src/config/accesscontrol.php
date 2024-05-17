<?php

return [
    'role_model' => flaviomartil\accesscontrol\models\Role::class,
    'permission_model' => flaviomartil\accesscontrol\models\Permission::class,
    'module_model' => flaviomartil\accesscontrol\models\Module::class,
    'group_access_table' => 'group_access',
    'permission_role_table' => 'permission_role',
    'user_id_column' => 'user_id',
    'role_id_column' => 'role_id',
    'permission_id_column' => 'permission_id',
    'module_id_column' => 'module_id',
    'tenant' =>
    [
    'use_tenant' => true ,
    'tenant_identifier_model' => Stancl\Tenancy\Contracts\Tenant::class, // Default for stancl laravel for tenancy
    'tenant_key' => 'id',
    ]
];
