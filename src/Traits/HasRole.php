<?php 
/**
* HasRole Trait
* @version v1.0.0
* @author Saiful Alam
* @package RoleManager
*/
namespace MSAR\RoleManager\Traits;

trait HasRole
{
	public function hasRole($role = null): bool
	{
		return $role == $this->role;
	}
}