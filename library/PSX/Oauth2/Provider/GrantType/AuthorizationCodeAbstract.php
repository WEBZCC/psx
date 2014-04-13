<?php
/*
 * psx
 * A object oriented and modular based PHP framework for developing
 * dynamic web applications. For the current version and informations
 * visit <http://phpsx.org>
 *
 * Copyright (c) 2010-2014 Christoph Kappestein <k42b3.x@gmail.com>
 *
 * This file is part of psx. psx is free software: you can
 * redistribute it and/or modify it under the terms of the
 * GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or any later version.
 *
 * psx is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with psx. If not, see <http://www.gnu.org/licenses/>.
 */

namespace PSX\Oauth2\Provider\GrantType;

use PSX\Oauth2\Provider\Credentials;
use PSX\Oauth2\Provider\GrantTypeInterface;
use PSX\Oauth2\Authorization\Exception\InvalidRequestException;

/**
 * AuthorizationCodeAbstract
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GPLv3
 * @link    http://phpsx.org
 */
abstract class AuthorizationCodeAbstract implements GrantTypeInterface
{
	public function getType()
	{
		return self::TYPE_AUTHORIZATION_CODE;
	}

	public function generateAccessToken(Credentials $credentials = null, array $parameters)
	{
		if($credentials === null)
		{
			throw new InvalidRequestException('Credentials not available');
		}

		$code        = isset($parameters['code']) ? $parameters['code'] : null;
		$redirectUri = isset($parameters['redirect_uri']) ? $parameters['redirect_uri'] : null;
		$clientId    = isset($parameters['client_id']) ? $parameters['client_id'] : null;

		return $this->generate($credentials, $code, $redirectUri, $clientId);
	}

	abstract protected function generate(Credentials $credentials, $code, $redirectUri, $clientId);
}
