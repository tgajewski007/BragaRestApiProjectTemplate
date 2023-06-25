<?php
namespace braga\requpero\base;
use braga\graylogger\Factory;
use braga\requpero\utils\logger\MainLogger;
use braga\tools\security\OAuth2Token;
use braga\tools\security\Security;

/**
 * Created on 22 lip 2018 11:04:05
 * error prefix CB:903
 * @author Tomasz Gajewski
 * @package
 *
 */
class Perms extends Security
{
	use OAuth2Token;
	// -----------------------------------------------------------------------------------------------------------------
	public function check(?array ...$roleName)
	{
		$u = parent::check(...$roleName);
		Factory::setUserNameContext($u->getLogin(), $u->getIdUser(), self::getJwt()->claims()->get("session_state"));
		return $u;
	}
	// -----------------------------------------------------------------------------------------------------------------
}
