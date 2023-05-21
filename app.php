<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Bondar\Swisnife\App;

// ini_set('error_reporting', 0);

require_once __DIR__ . '/vendor/autoload.php';

$thingsToDo = [
	[
		'module' => 'ya_metrika',
		'action' => 'goal',
		'events' => [
			'rtest' => [
				'_ym_uid' => '1684659680890579402',
				'datetime' => time(),
				'price' => '1',
				'currency' => 'RUB',
			],
		],
	],
	// [
	// 	'module' => 'ya_metrika',
	// 	'action' => 'oauth',
	// ],
];

App::exec($thingsToDo);
