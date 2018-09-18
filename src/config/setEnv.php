<?php

/**
 * Created on 22 sty 2018 10:39:20
 * error prefix
 * @author Tomasz Gajewski
 * @package
 *
 */
mb_internal_encoding("utf8");
ini_set("max_execution_time", "1800");
date_default_timezone_set("Europe/Warsaw");

if(file_exists(__DIR__ . "/devEnv.php"))
{
	require_once __DIR__ . "/devEnv.php";
}

/* PHP DATE FORMAT DEFAULT */
define("PHP_DATE_FORMAT", "Y-m-d");
define("PHP_TIME_FORMAT", "H:i:s");
define("PHP_DATETIME_FORMAT", PHP_DATE_FORMAT . " " . PHP_TIME_FORMAT);

Logger::configure(\braga\project\config\Config::getLog4PhpConfigFile());
set_error_handler("\\braga\\project\\utils\\ErrorHandler::errorHandler");
set_exception_handler("\\braga\\project\\utils\\ErrorHandler::exceptionHandler");