<?php

namespace Bondar\Swisnife\Config;

use Bondar\Swisnife\Config\ConfigException;

class Config
{
	public static function setEnvVars()
	{
		$config = file_get_contents(
			__DIR__
			. DIRECTORY_SEPARATOR
			. '..'
			. DIRECTORY_SEPARATOR
			. '..'
			. DIRECTORY_SEPARATOR
			. '..'
			. DIRECTORY_SEPARATOR
			. '..'
			. DIRECTORY_SEPARATOR
			. '.ENV'
		);

		foreach (explode(PHP_EOL, $config) as $line) {
			if (strpos($line, '#') === 0 || empty($line)) {
				continue;
			}
// echo $line;
// echo "<br>";
// echo trim($line);
// echo "<br>";
			// $line = trim($line);
			if (!putenv($line)) {
				throw new ConfigException('invalid env variable assignment');
			}
		}
	}
}
