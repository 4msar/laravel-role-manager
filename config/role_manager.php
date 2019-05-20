<?php 
/**
* config/role_manafer config file
* @version v1.0.0
* @author Saiful Alam
* @package RoleManager
*/
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