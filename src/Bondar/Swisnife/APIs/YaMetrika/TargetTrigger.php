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

	// Тип идентификаторов посетителей – CLIENT_ID, USER_ID или YCLID :
	private static $clientIdType = 'CLIENT_ID';

	public static function sendEvents($events)
	{
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
		// $data = [
		// 	'clitype' => static::$clientIdType,
		// 	'ym_counter_id' => getenv('ym_counter_id'),
		// 	'ym_access_token' => getenv('ym_access_token'),
		// 	'fileName' => realpath(static::$fileName),
		// ];
		// echo "<pre>";
		// print_r($data);die;
		$curl = curl_init('https://api-metrika.yandex.ru/management/v1/counter/'
			. getenv('ym_counter_id')
			. '/offline_conversions/upload?client_id_type='
			. static::$clientIdType);

		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, array('file' => new \CURLFile(realpath(static::$fileName))));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data', 'Authorization: OAuth ' . getenv('ym_access_token')));
file_put_contents(__DIR__ . '/log.log', print_r($curl, true) . PHP_EOL, FILE_APPEND);

		$result = curl_exec($curl);
		$error = curl_errno($curl);
file_put_contents(__DIR__ . '/log.log', print_r($error, true) . PHP_EOL, FILE_APPEND);

file_put_contents(__DIR__ . '/log.log', $result . PHP_EOL, FILE_APPEND);

		curl_close($curl);
	}
}