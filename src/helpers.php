<?php 
/**
* Helper functions 
* @version v1.0.0
* @author Saiful Alam
* @package RoleManager
*/

if( ! function_exists('pipeToArray')){
	/**
	* Convert pipe(|) string to array
	* @version v1.0.0
	* @since v1.0.0
	*/
	function pipeToArray($data){
		$array = [];
		if(is_string($data) && strpos($data, '|') > 0){
			$array = explode('|', $data);
		}

		if(is_string($data)){
			$array = explode('|', $data);
		}

		if(is_array($data)){
			$array = $data;
		}

		return $array;
	}
}

if( ! function_exists('rmHasRole')){
	/**
	* role manager has role | rmHasRole
	* Check the logged in user role
	* @version v1.0.0
	* @since v1.0.0
	*/
	function rmHasRole($role) : bool {
		if(is_array($role)){
			return in_array(auth()->user()->role, $role);
		}

		if(is_string($role) && strpos($role, '|') > 0){
			$role = pipeToArray($role);
			return in_array(auth()->user()->role, $role);
		}

		if(is_string($role)){
			return auth()->user()->role == $role;
		}

		return false;
	}
}

if( ! function_exists('rmHasPermission')){
	/**
	* role manager has permission | rmHasPermission
	* Check the logged in user role
	* @version v1.0.0
	* @since v1.0.0
	*/
	function rmHasPermission($permissions) : bool {
		$permissions = pipeToArray($permission);
        if($permissions){
            foreach ($permissions as $value) {
                if(auth()->check() && auth()->user()->hasPermission($value)){
                    return true;
                }
            }
        }

		return false;
	}
}