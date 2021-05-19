<?php
namespace braga\project\base;
use braga\project\obj\KeyStore;
use braga\tools\security\SecurityConfig;
class PermsConfig extends SecurityConfig
{
	// -----------------------------------------------------------------------------------------------------------------
	public function getPublicKey($kid)
	{
		return KeyStore::get($kid)->getPublicKey();
	}
	// -----------------------------------------------------------------------------------------------------------------
}
