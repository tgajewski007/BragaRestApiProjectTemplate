<?php
namespace braga\requpero\base;
use braga\db\exception\ExecutionSqlException;
use braga\requpero\config\Config;
use braga\requpero\obj\KeyStore;
use braga\tools\security\OAuth2PublicKey;
use braga\tools\security\SecurityConfig;
class PermsConfig extends SecurityConfig
{
	use OAuth2PublicKey;
	// -----------------------------------------------------------------------------------------------------------------
	public function getPublicKey($kid)
	{
		try
		{
			return KeyStore::get($kid)->getPublicKey();
		}
		catch(ExecutionSqlException $e)
		{
			return KeyStore::createFromJwt($this->getPublicKeyFromAuthService(Config::getIssuerRealms(), $kid), $kid)->getPublicKey();
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
}
