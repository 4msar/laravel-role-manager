
# Laravel Role Manager

* [Installation](#installation)
* [Usage](#usage)
* [Todo](#todo)


## Installation

This package can be used in Laravel 5.4 or higher.
You can install the package via composer:

``` bash
composer require 4msar/laravel-role-manager
```

In Laravel 5.5 the service provider will automatically get registered. In older versions of the framework just add the service provider in `config/app.php` file:

```php
'providers' => [
    // ...
    MSAR\RoleManager\RoleManagerServiceProvider::class,
];
```

You can publish the migrations & config file with:

```bash
php artisan vendor:publish --provider="MSAR\RoleManager\RoleManagerServiceProvider"
```

After the migration has been published you can create the role- and permission-tables by running the migrations:

```bash
php artisan migrate
```

When published, the `config/role_manager.php` config file contains:

```php
return [

    /**
    * Permission List 
    * Here, you can declare your needed permission, the package will be add this permission automatically
    * to the database( via middle-ware).
    * key name is the permission name and value is the details name showing for management.
    */
    "add_permission_dynamically" => false, // Make true if you want to add permission from bellow permissions array
    "permissions" => [
        // 'permission_name' => 'permission_details'
        'view_home' => 'View Admin Dashboard',
        'view_users' => 'View Admin Users',
    ],

    'unauthorized_action' => '',

    'unauthorized_action_type' =>  [
        'route' => [
            'name' => 'welcome',
            'data' => [],
        ],
        'url' => [
            'name' => '/login',
            'data' => [],
        ],
        'abort' => [
            'type' => '403',
        ],
        'dump' => [
            'data' => 'Dumping a unauthorized message.',
        ]
    ],

    "database" => [
        "role_table" => "roles",
        "permission_table" => "permissions",
        "role_permission_table" => "permission_role",
    ],
];
```



## Usage

First, add the `MSAR\RoleManager\Traits\HasPermission;` trait to your `User` model(s):

```php
use Illuminate\Foundation\Auth\User as Authenticatable;
use MSAR\RoleManager\Traits\HasPermission;;

class User extends Authenticatable
{
    use HasPermission;

    // ...
}
```

Then, add the `\MSAR\RoleManager\Middlewares\RoleMiddleware::class` middlwware to your `Karnel.php` :

```php
// .....
'has_permission' => \MSAR\RoleManager\Middlewares\RoleMiddleware::class,
```
> **NB: You have to add a column to your users table name is ``role`` and the users role is save to this column**

This package allows for users to be associated with permissions and roles. Every role is associated with multiple permissions.
A `Role` and a `Permission` are regular Eloquent models. They require a `name` and can be created like this:

```php
use MSAR\RoleManager\Models\Role;
use MSAR\RoleManager\Models\Permission;

$role = Role::create(['name' => 'writer']);
$permission = Permission::create(['name' => 'edit_articles', 'title' => 'Edit Articles']);
```
To create permission you can use the ``config/role_manager.php`` file and the ``permissions`` array.
just make the config value ``add_permission_dynamically`` to ``true``  then add permission to the array(``permissions``).

For updating role and permission from front-end, use the code bellow

```php
$role = \MSAR\RoleManager\Models\Role::where('name', 'Admin')->first();
$permissions = $request->permissions; // [1,2] | checkbox array input | permissions ids
$role->permissions()->sync($permissions);
```

For check the user has permission or not use the middleware to the route
```php
Route::get('/users', 'UserController@index')->middleware('has_permission:view_users')->name('home');
```
You can use multiple permission by using the pipe(|) eg: ``has_permission:view_users|update_users``

**Use Blade Directives**
You can use those blade extension 
Has Role :  Has Role
```php
@hasrole(role)
@elsehasrole(another_role)
@endhasrole
```
Has Permission :  User can
```php
@ucan(permission)
@elseucan(another_permission)
@enducan
```

**Use Helper Functions**
```php
rmHasRole($role); // pipe string | array | string
rmHasPermission($permission); // pipe string | array | string
```


## Todo

- Improve code base
- Add Command to add a role or assign permission