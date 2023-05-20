<?php

namespace Bondar\Swisnife\APIs\YaMetrika;

// $events = [
// 	'roiform' => [
// 		'_ym_uid' => '1684498026684853526',
// 		'datetime' => '1684499227',
// 		'price' => '0.00',
// 		'currency' => 'RUB',
// 	],
// ];

class TargetTrigger
{
	// private $clientSecret = '9539c29b597b4062a1749151e1bf1fe4';
	// private $clientId = '83e5208cc4c8438785d8a8fa9bc9cec5';

	// Имя отправляемого файла с событиями :
	private static $fileName = __DIR__ . DIRECTORY_SEPARATOR . 'file.csv';

	// Номер счетчика :
	private static $counterId = '53244133';

	// OAuth-токен :
	private static $accessToken = 'y0_AgAAAABrI-jXAAnupQAAAADjgx7DGz9vGOW1QmCFRGGrkoQwkMTJUiY';

	// Тип идентификаторов посетителей – CLIENT_ID, USER_ID или YCLID :
	private static $clientIdType = 'CLIENT_ID';

	public static function sendEvents($events)
	{
		echo "<pre>";
		print_r($events);
		return;
		
		$tableStr = 'ClientId,Target,DateTime,Price,Currency' . PHP_EOL;

		foreach ($events as $eName => $eData) {
			$tableStr .= $eData['_ym_uid']
				. ','
				. $eName
				. ','
				. $eData['datetime']
				. ','
				. $eData['price']
				. ','
				. $eData['currency']
				. PHP_EOL;

		}

		file_put_contents(static::$fileName, $tableStr);
file_put_contents(__DIR__ . '/log.log', print_r($tableStr, true) . PHP_EOL, FILE_APPEND);
		static::send();

		unlink(static::$fileName);
	}

	private static function send()
	{
		$curl = curl_init('https://api-metrika.yandex.ru/management/v1/counter/'
			. static::$counterId
			. '/offline_conversions/upload?client_id_type='
			. static::$clientIdType);

		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, array('file' => new CURLFile(realpath(static::$fileName))));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data', 'Authorization: OAuth ' . static::$accessToken));

		$result = curl_exec($curl);

file_put_contents(__DIR__ . '/log.log', print_r($result, true) . PHP_EOL, FILE_APPEND);

		curl_close($curl);
	}
}