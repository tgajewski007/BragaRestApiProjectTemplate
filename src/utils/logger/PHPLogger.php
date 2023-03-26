<?php
namespace braga\project\utils\logger;
use braga\graylogger\BaseLogger;
use braga\tools\tools\JsonSerializer;
use Exception;
use Monolog\Level;
use Throwable;
use braga\graylogger\Factory;
use Monolog\Logger;
class PHPLogger extends BaseLogger
{
	const NAME = "php";
	// -----------------------------------------------------------------------------------------------------------------
	/**
	 * @param $errno
	 * @param $errstr
	 * @param $errfile
	 * @param $errline
	 * @return bool
	 * @throws Exception
	 */
	public static function handleError($errno, $errstr, $errfile, $errline)
	{
		if((error_reporting() & $errno))
		{
			$l = Factory::getInstance(self::NAME);
			$stack = JsonSerializer::toJson(debug_backtrace());
			$msg = $errno . " " . $errstr . " file: " . $errfile . " line: " . $errline;
			switch($errno)
			{
				case E_CORE_ERROR:
				case E_PARSE:
				case E_ERROR:
				case E_COMPILE_ERROR:
				case E_USER_ERROR:
				case E_STRICT:
				case E_RECOVERABLE_ERROR:
				case E_ALL:
					$l->error($msg, [
						"stack" => $stack]);
					throw new Exception($errstr, $errno);
				case E_CORE_WARNING:
				case E_COMPILE_WARNING:
				case E_WARNING:
				case E_USER_WARNING:
				case E_DEPRECATED:
				case E_USER_DEPRECATED:
					$l->warning($msg, [
						"stack" => $stack]);
					break;
				case E_NOTICE:
				case E_USER_NOTICE:
					$l->info($msg, [
						"stack" => $stack]);
					break;
			}
		}
		return false;
	}
	// -----------------------------------------------------------------------------------------------------------------
	public static function handleException(Throwable $exception)
	{
		Factory::getInstance(self::NAME)->exception($exception, Level::Emergency);
		return false;
	}
	// -----------------------------------------------------------------------------------------------------------------
}