<?php

return [
	
	'user-management' => [
		'title' => 'User Management',
		'created_at' => 'Time',
		'fields' => [
		],
	],
	
	'permissions' => [
		'title' => 'Permissions',
		'created_at' => 'Time',
		'fields' => [
			'title' => 'Title',
		],
	],
	
	'roles' => [
		'title' => 'Roles',
		'created_at' => 'Time',
		'fields' => [
			'title' => 'Title',
			'permission' => 'Permissions',
		],
	],
	
	'users' => [
		'title' => 'Users',
		'created_at' => 'Time',
		'fields' => [
			'name' => 'Name',
			'email' => 'Email',
			'password' => 'Password',
			'role' => 'Role',
			'remember-token' => 'Remember token',
		],
	],
	'app_create' => 'Create',
	'app_save' => 'Save',
	'app_edit' => 'Edit',
	'app_view' => 'View',
	'app_update' => 'Update',
	'app_list' => 'List',
	'app_no_entries_in_table' => 'No entries in table',
	'custom_controller_index' => 'Custom controller index.',
	'app_logout' => 'Logout',
	'app_add_new' => 'Add new',
	'app_are_you_sure' => 'Are you sure?',
	'app_back_to_list' => 'Back to list',
	'app_dashboard' => 'Dashboard',
	'app_delete' => 'Delete',
	'global_title' => 'Quick LMS',
];