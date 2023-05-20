<?php

namespace Bondar\Swisnife\Helpers;

class CaseSwitcher {

	public static function getSnakeFromCamel(string $input) : string
	{
		return preg_replace("/([A-Z])/u", '_$1', $input);
	}

	public static function getCamelBySeparator(string $input, string $separator = '_') : string
	{
		return str_replace($separator, '', lcfirst(ucwords($input, $separator)));
	}

	public static function getPascalBySeparator(string $input, string $separator = '_') : string
	{
		return ucfirst(str_replace($separator, '', ucwords($input, $separator)));
	}
}
