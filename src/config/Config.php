<?php
namespace braga\project\config;
/**
 * Created on 22 sty 2018 09:56:10
 * error prefix
 * @author Tomasz Gajewski
 * @package
 *
 */
class Config
{
	// -----------------------------------------------------------------------------------------------------------------
	private static $iniContent;
	// -----------------------------------------------------------------------------------------------------------------
	private static function getEnviromentVariable($name)
	{
		if(empty(self::$iniContent))
		{
			self::$iniContent = array();
		}

		self::$iniContent[$name] = getenv($name);

		if(self::$iniContent[$name] !== false)
		{
			return self::$iniContent[$name];
		}
		else
		{
			throw new \Exception("BR:90001 Nie zdefiniowano zmiennej systemowej: " . $name . " popraw konfiguracje dockera");
		}
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function getVersion()
	{
		return "1";
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function getDbConnectionString()
	{
		return self::getEnviromentVariable("DBCONNECTIONSTRING");
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function getDbSchema()
	{
		return self::getEnviromentVariable("DBSCHEMA");
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function getDbUser()
	{
		return self::getEnviromentVariable("DBUSER");
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function getDbPassword()
	{
		return self::getEnviromentVariable("DBPASS");
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function getInstallDirectory()
	{
		return realpath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR;
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function getIssuerRealms()
	{
		return self::getEnviromentVariable("ISSUERREALMS");
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function getLog4PhpConfigFile()
	{
		return self::getEnviromentVariable("LOG4PHPCONFIGFILE");
	}
	// -----------------------------------------------------------------------------------------------------------------
}