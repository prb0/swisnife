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
			'roiform' => [
				'_ym_uid' => '1684498026684853526',
				'datetime' => '1684499227',
				'price' => '0.00',
				'currency' => 'RUB',
			],
		],
	],
];

App::exec($thingsToDo);
