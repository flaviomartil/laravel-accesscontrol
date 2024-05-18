<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Access Control</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2, h3, h4, h5, h6 {
            color: #333;
        }
        pre {
            background: #333;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            overflow-x: auto;
        }
        code {
            color: #c7254e;
            background: #f9f2f4;
            padding: 2px 4px;
            border-radius: 4px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background: #eee;
            margin: 5px 0;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laravel Access Control</h1>

        <h2>How to Install:</h2>
        <pre><code>composer require flaviomartil/laravel-accesscontrol</code></pre>

        <h2>Publish Assets:</h2>
        <pre><code>php artisan vendor:publish --provider="FlavioMartil\AccessControl\ServiceProvider\AccessControlProvider"</code></pre>

        <h2>Configuration:</h2>
        <ul>
            <li><strong>Prefix:</strong> Routes prefix</li>
            <li><strong>Middleware:</strong> Middleware for the routes</li>
            <li><strong>role_model:</strong> Model for role</li>
            <li><strong>permission_model:</strong> Model for permissions</li>
            <li><strong>group_access_table:</strong> Table that links users to roles</li>
            <li><strong>permission_role_table:</strong> Table linking permissions to roles</li>
            <li><strong>user_id_column:</strong> User ID in the relationship</li>
            <li><strong>role_id_column:</strong> Role ID in the relationship</li>
            <li><strong>permission_id_column:</strong> Permission ID in the relationship</li>
            <li><strong>module_id_column:</strong> Module ID in the relationship</li>
        </ul>

        <h2>Tenant Configurations:</h2>
        <p>Currently functional with Stancl Laravel For Tenancy:</p>
        <ul>
            <li><strong>use_tenant:</strong> Whether to use tenancy logic</li>
            <li><strong>tenant_identifier_model:</strong> Identification model for tenancy (default: <code>Stancl\Tenancy\Contracts\Tenant::class</code>)</li>
            <li><strong>tenant_key:</strong> Key to get tenant (using <code>tenant('id')</code> in command)</li>
        </ul>

        <h3>For cases with Laravel For Tenancy:</h3>
        <p>Open <code>AuthServiceProvider</code>:</p>
        <pre><code>

Route::group([
'middleware' => [
InitializeTenancyByDomain::class
],
'prefix' => config('accesscontrol.prefix'),
'namespace' => 'FlavioMartil\AccessControl\Controllers',
], function () {
$this->loadRoutesFrom(__DIR__ . "/../../vendor/flaviomartil/laravel-accesscontrol/src/assets/routes.php");
});
</code></pre>
<p>Add to the <code>boot</code> method, so it will initialize the tenant for our routes.</p>

        <h3>In the <code>Kernel.php</code> file, find <code>$routeMiddleware</code> and add:</h3>
        <pre><code>'permission' => \FlavioMartil\AccessControl\Middleware\CheckPermissionMiddleware::class,</code></pre>

        <h2>To use it, go to your routes file and:</h2>
        <pre><code>

Route::middleware(['passport.auth','permission:view_me'])->get('
me', [App\Http\Controllers\Identity\IdentityController::class, 'me']);
</code></pre>
<p><strong>permission:</strong><em>name_of_permission</em></p>
</div>
</body>
</html>