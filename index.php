<?php
setlocale(LC_ALL, 'en_US.utf8');

require 'config.php';

function respond($message, $status) {
	header('Status: ' . $status, true, $status);
	header('Content-Type: text/plain');

	if($status == 401)
		header('WWW-Authenticate: AA-Hash-md5 realm=' . $_SERVER['SERVER_NAME']);

	die($message . "\n");
}

function check($user, $hash, $salt) {
	global $CONFIG;

	$mysql = new mysqli($CONFIG['host'], $CONFIG['user'], $CONFIG['pass'], $CONFIG['database']);
	$result = $mysql->query('SELECT `' . $CONFIG['user_col'] . '`, `' . $CONFIG['hash_col'] . ($CONFIG['role_col'] !== '' ? '`, `' . $CONFIG['role_col'] : '') . '` FROM `' . $CONFIG['table'] . '` WHERE `' . $CONFIG['user_col'] . '`="' . $mysql->real_escape_string($user) . '"');
	if($result->num_rows == 1) {
		$array = $result->fetch_row();
		$result->close();
		$mysql->close();

		$role = '';
		if($CONFIG['role_col'] !== '') {
			if(isset($CONFIG['roles'][$array[2]]))
				$role = '/' . $CONFIG['roles'][$array[2]];
			else if($CONFIG['role_required'])
				respond('USER_NOT_FOUND', 404);
		}

		if($hash === md5(pack('H*', $array[1]) . $salt))
			respond('PASSWORD_OK ' . iconv('UTF-8', 'ASCII//TRANSLIT', $array[0]) . '@' . $_SERVER['SERVER_NAME'] . $role, 200);
		else
			respond('PASSWORD_FAIL', 401);
	}
	else {
		$result->close();
		$mysql->close();
		respond('USER_NOT_FOUND', 404);
	}
}

switch(isset($_REQUEST['query']) ? $_REQUEST['query'] : '') {
	case 'methods':
		respond('methods md5', 200);
	case 'versions':
		respond('0.1', 200);
	case 'params':
		respond('prefix ' . $CONFIG['pass_prefix'] . "\n" . 'suffix ' . $CONFIG['pass_suffix'] . "\n", 200);
	case 'check':
		if($_REQUEST['method'] === 'md5')
			check($_REQUEST['user'], $_REQUEST['hash'], pack('H*', $_REQUEST['salt']));
		else
			respond('METHOD_NOT_IMPLEMENTED', 501);
	default:
		respond('UNKNOWN_QUERY', 404);
}
?>
