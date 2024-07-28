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
	private static array $iniContent = [];
	// -----------------------------------------------------------------------------------------------------------------
	public static function putenv($key, $val)
	{
		self::$iniContent[$key] = $val;
	}
	// -----------------------------------------------------------------------------------------------------------------
	private static function getEnviromentVariable($name)
	{
		if(!isset(self::$iniContent[$name]))
		{
			$var = getenv($name);
			if($var === false)
			{
				throw new \Exception("CHANGE_ME:90501 Nie zdefiniowano zmiennej systemowej: " . $name . " popraw konfiguracje dockera", 90501);
			}
			self::$iniContent[$name] = $var;
		}
		return self::$iniContent[$name];
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
	public static function getGelfHost()
	{
		return self::getEnviromentVariable("GELF_HOST");
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function getGelfPort()
	{
		return self::getEnviromentVariable("GELF_PORT");
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function getLogLevel()
	{
		return self::getEnviromentVariable("LOG_LEVEL");
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function getLogFile()
	{
		return self::getEnviromentVariable("LOG_FILE");
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function getClientId()
	{
		return self::getEnviromentVariable("AUTH_CLIENT_ID");
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function getClientSecret()
	{
		return self::getEnviromentVariable("AUTH_CLIENT_SECRET");
	}
	// -----------------------------------------------------------------------------------------------------------------
}