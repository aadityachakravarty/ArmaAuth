<?php
$CONFIG = array(
	//Database information

	//MySQL host address, use localhost if unsure
	'host'		=> 'localhost',

	//Username for database
	'user'		=> 'root',

	//Password for database
	'pass'		=> 'letmein',

	//MySQL database to connect to
	'database'	=> 'database',

	//Table containing login information
	'table'		=> 'users',

	//Username column
	'user_col'	=> 'username',

	//Hash column, contains the md5 of the password after the prefixes and suffixes have been appended
	'pass_prefix'	=> '',
	'pass_suffix'	=> '',
	'hash_col'	=> 'password',

	//Role column, optionally contains the index of the user role (blank if disabled), it is designed to fit in with forums
	'role_col'	=> 'group_id',
	'roles'		=> array(
		'0'	=> 'Administrator',
		'1'	=> 'Member'
	)
);
?>
