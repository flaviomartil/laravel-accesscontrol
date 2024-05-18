# Laravel Access Control

## How to Install:
composer require flaviomartil/laravel-accesscontrol

## Publish Assets:
php artisan vendor:publish --provider="FlavioMartil\AccessControl\ServiceProvider\AccessControlProvider"

## Configuration:
- **Prefix:** Routes prefix
- **Middleware:** Middleware for the routes
- **role_model:** Model for role
- **permission_model:** Model for permissions
- **group_access_table:** Table that links users to roles
- **permission_role_table:** Table linking permissions to roles
- **user_id_column:** User ID in the relationship
- **role_id_column:** Role ID in the relationship
- **permission_id_column:** Permission ID in the relationship
- **module_id_column:** Module ID in the relationship

## Tenant Configurations:
Currently functional with Stancl Laravel For Tenancy:

- **use_tenant:** Whether to use tenancy logic
- **tenant_identifier_model:** Identification model for tenancy (default: `Stancl\Tenancy\Contracts\Tenant::class`)
- **tenant_key:** Key to get tenant (using `tenant('id')` in command)

## Additional Instructions:

### For cases with Laravel For Tenancy:
Open `AuthServiceProvider` and add the following code:

Route::group([
    'middleware' => [
        InitializeTenancyByDomain::class
    ],
    'prefix' => config('accesscontrol.prefix'),
    'namespace' => 'FlavioMartil\AccessControl\Controllers',
], function () {
    $this->loadRoutesFrom(__DIR__ . "/../../vendor/flaviomartil/laravel-accesscontrol/src/assets/routes.php");
});

Add to the `boot` method, so it will initialize the tenant for our routes.

### In the `Kernel.php` file
Find `$routeMiddleware` and add:
'permission' => \FlavioMartil\AccessControl\Middleware\CheckPermissionMiddleware::class,

### To use it
Go to your routes file and add:
Route::middleware(['passport.auth','permission:view_me'])->get('me', [App\Http\Controllers\Identity\IdentityController::class, 'me']);

- Format for permission: `permission:name_of_permission`
