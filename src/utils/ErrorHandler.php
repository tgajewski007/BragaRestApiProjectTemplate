<?php
namespace braga\project\utils;

/**
 * Created on 17.09.2016 17:49:02
 * error prefix
 * @author Tomasz Gajewski
 * @package
 *
 */
class ErrorHandler
{
	// -------------------------------------------------------------------------
	public static function errorHandler($errno, $errstr, $errfile, $errline)
	{
		$l = \Logger::getLogger("php");
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
				break;
			case E_CORE_WARNING:
			case E_COMPILE_WARNING:
			case E_WARNING:
			case E_USER_WARNING:
			case E_DEPRECATED:
			case E_USER_DEPRECATED:
				$l->warn($msg);
				break;
			case E_NOTICE:
			case E_USER_NOTICE:
				$l->info($msg);
				break;
		}
		return false;
	}
	// -------------------------------------------------------------------------
	public static function exceptionHandler(\Throwable $exception)
	{
		$msg = $exception->getCode() . " ";
		$msg .= $exception->getMessage() . " ";
		$msg .= $exception->getFile() . " ";
		$msg .= $exception->getLine();

		\Logger::getLogger("php")->error($msg);
		return false;
	}
	// -------------------------------------------------------------------------
}
?>