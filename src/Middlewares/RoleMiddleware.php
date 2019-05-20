<?php
/**
* RoleMiddleware to handle the permission
* @version v1.0.0
* @author Saiful Alam
* @package RoleManager
*/
namespace MSAR\RoleManager\Middlewares;

use Schema;
use Closure;
use MSAR\RoleManager\Models\Role;
use MSAR\RoleManager\Models\Permission;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{

    public function __construct()
    {
        $permissions = config('role_manager.permissions');
        $dynamically = config('role_manager.add_permission_dynamically');

        if ($dynamically == true && Schema::hasTable(config('role_manager.database.permission_table'))) {
            foreach ($permissions as $key => $value) {
                $insert = Permission::firstOrNew(['name' => $key]);
                $insert->name = $key;
                $insert->title = $value;
                $insert->save();
            }
        }
    }

    public function handle($request, Closure $next, $permission = null)
    {
        if (Auth::guest()) {
            return redirect('/login');
        }
        $permissions = pipeToArray($permission);
        if($permissions){
            foreach ($permissions as $value) {
                if(auth()->check() && ! auth()->user()->hasPermission($value)){
                    return $this->unauthorizedAction();
                }
            }
        }
        return $next($request);
    }

    public function unauthorizedAction()
    {
        $unauthorized = config('role_manager.unauthorized_action');
        switch ($unauthorized) {
            case 'route':
                $routeName = config('role_manager.unauthorized_action_type.route.name');
                $data = config('role_manager.unauthorized_action_type.route.data');
                return redirect()->route($routeName)->with(['data' => $data]);
                break;

            case 'url':
                $url = config('role_manager.unauthorized_action_type.url.name');
                $data = config('role_manager.unauthorized_action_type.url.data');
                return redirect($url)->with(['data' => $data]);
                break;

            case 'abort':
                abort(config('role_manager.unauthorized_action_type.abort.type'));
                break;

            case 'dump':
                $dump = config('role_manager.unauthorized_action_type.dump.data');
                dd($dump);
                break;

            case '403':
            case 'default':
            default:
                abort(403);
                break;
        }
    }
}
