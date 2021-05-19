<?php
namespace braga\project\utils\logger;
use braga\graylogger\BaseLogger;
use Exception;
use Throwable;
use braga\graylogger\Factory;
use Monolog\Logger;
class PHPLogger extends BaseLogger
{
	const NAME = "php";

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
		$l = Factory::getInstance(self::NAME);
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
				$l->error($msg);
				throw new Exception($errstr, $errno);
				break;
			case E_CORE_WARNING:
			case E_COMPILE_WARNING:
			case E_WARNING:
			case E_USER_WARNING:
			case E_DEPRECATED:
			case E_USER_DEPRECATED:
				$l->warning($msg);
				break;
			case E_NOTICE:
			case E_USER_NOTICE:
				$l->info($msg);
				break;
		}
		return false;
	}
	public static function handleException(Throwable $exception)
	{
		$msg = $exception->getCode() . " ";
		$msg .= $exception->getMessage() . " ";
		$msg .= $exception->getFile() . " ";
		$msg .= $exception->getLine();

		$l = Factory::getInstance(self::NAME);
		$l->error($msg);
		$l->exception($exception, Logger::CRITICAL);
		return false;
	}
}