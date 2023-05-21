<?php

namespace Bondar\Swisnife\APIs\YaMetrika;

use Yandex\OAuth\OAuthClient;

class OAuth
{
	public static function redirect()
	{
		$client = new OAuthClient(trim(getenv('ym_client_id')));
		// В последнем аргументе authRedirect можно указать строку состояния, 
		// которая будет передана в параметрах запроса при возвращении пользователя на Callback URI
		$state = 'yandex-php-library';
		$client->authRedirect(true, OAuthClient::TOKEN_AUTH_TYPE, $state, ['crutch' => '0']);  
	}
}
