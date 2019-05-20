<?php 
/**
* HasPermission Trait
* @version v1.0.0
* @author Saiful Alam
* @package RoleManager
*/
namespace MSAR\RoleManager\Traits;

use HasRole;
use MSAR\RoleManager\Models\Role;

trait HasPermission
{
	public function hasPermission($name)
	{
		$role = Role::where('name', $this->role)->first();
		if($role && $role->permissions->contains('name', $name)) return true;

		return false;
	}
}