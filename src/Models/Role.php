<?php
/**
* Role Model
* @version v1.0.0
* @author Saiful Alam
* @package RoleManager
*/
namespace MSAR\RoleManager\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	
	protected $fillable = ['name', 'status'];
    public function __construct()
    {
        $this->setTable(config('role_manager.database.role_table'));
    }

    /**
     * Relationship with pivot table
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, config('role_manager.database.role_permission_table'));
    }

    /**
     * Save the permission to the pivot table
     *
     * @param  array  $permission_ids
     * @param  string   $role
     * @return array
     */
    public function savePermission(array $permission_ids = [], string $role = null )
    {
        if($role == null){
            $role = $this;
        }else{
            $role = self::firstOrNew(['name' => $role]);
        }
        
        $role->permissions()->sync($permission_ids);

        return $role;
    }
}
