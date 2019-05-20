<?php
/**
* Permission Model
* @version v1.0.0
* @author Saiful Alam
* @package RoleManager
*/
namespace MSAR\RoleManager\Models;

use Schema;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	
	protected $fillable = ['name', 'title'];
	
    public function __construct()
    {
        $this->setTable(config('role_manager.database.permission_table'));
    }


    /**
     * Relationship with pivot table
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, config('role_manager.database.role_permission_table'));
    }
}
