<?php

namespace Bondar\Swisnife\APIs\YaMetrika;

use Bondar\Swisnife\APIs\YaMetrika\OAuth;
use Bondar\Swisnife\APIs\YaMetrika\TargetTrigger;
use Bondar\Swisnife\APIs\YaMetrika\YaMetrikaException;
use Bondar\Swisnife\Interfaces\HandlerInterface;

class Handler implements HandlerInterface
{
	public static function exec(array $args) : void
	{
		switch ($args['action']) {
			case 'goal':
				TargetTrigger::sendEvents($args['events']);
				break;

			case 'oauth':
				OAuth::redirect();
				break;
			
			default:
				throw new YaMetrikaException('invalid action param');
		}
	}
}
