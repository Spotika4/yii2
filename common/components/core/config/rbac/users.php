<?php

return [
	[
		'username' => 'User',
		'password' => 'User',
		'email' => 'user@user.com',
		'roles' => ['user'],
		'status' => common\components\core\models\ar\User::STATUS_ACTIVE,
	],
	[
		'username' => 'Moderator',
		'password' => 'Moderator',
		'email' => 'moderator@moderator.com',
		'roles' => ['moderator'],
		'status' => common\components\core\models\ar\User::STATUS_ACTIVE,
	],
	[
		'username' => 'Administrator',
		'password' => 'Administrator',
		'email' => 'administrator@administrator.com',
		'roles' => ['administrator'],
		'status' => common\components\core\models\ar\User::STATUS_ACTIVE,
	]
];
