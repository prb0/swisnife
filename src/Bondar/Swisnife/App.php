<?php

namespace Bondar\Swisnife;

use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use Bondar\Swisnife\Config\Config;
use Bondar\Swisnife\Helpers\CaseSwitcher;

class App
{
	public static function exec(array $thingsToDo) : void
	{
		try {
			Config::setEnvVars();

			foreach ($thingsToDo as $t) {
				$className = static::getHandlerPath($t['module']);

				$className::exec($t);
			}
		} catch (\Exception $e) {
			static::log($e);
		}
	}

	private static function getHandlerPath(string $input) : string
	{
		$module = CaseSwitcher::getPascalBySeparator($input, '_');

		return '\\Bondar\\Swisnife\\APIs\\' . $module . '\\Handler';
	}

	private static function log(\Exception $e) : void
	{
		$msg = $e->getMessage() . PHP_EOL . $e->getTraceAsString();
		$log = new Logger('swisnife');

		$log->pushHandler(new StreamHandler(
			__DIR__
				. DIRECTORY_SEPARATOR
				. '..'
				. DIRECTORY_SEPARATOR
				. '..'
				. DIRECTORY_SEPARATOR
				. '..'
				. DIRECTORY_SEPARATOR
				. 'logs'
				. DIRECTORY_SEPARATOR
				. 'main.log',
			Logger::WARNING
		));
		$log->warning($msg);
	}
}
