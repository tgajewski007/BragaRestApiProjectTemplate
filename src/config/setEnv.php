<?php

/**
 * Created on 22 sty 2018 10:39:20
 * error prefix
 * @author Tomasz Gajewski
 * @package
 *
 */
use braga\graylogger\Factory;
use braga\graylogger\GrayLoggerConfig;
use braga\project\base\Perms;
use braga\project\base\PermsConfig;
use braga\project\config\Config;
use braga\project\utils\logger\PHPLogger;

mb_internal_encoding("utf8");
ini_set("max_execution_time", "1800");
date_default_timezone_set("Europe/Warsaw");

if(file_exists(__DIR__ . "/devEnv.php"))
{
	require_once __DIR__ . "/devEnv.php";
}

/* DB CONFIGURACTION */
define("DB_CONNECTION_STRING", \braga\project\config\Config::getDbConnectionString());
define("DB_SCHEMA", \braga\project\config\Config::getDbSchema());
define("DB_USER", \braga\project\config\Config::getDbUser());
define("DB_PASS", \braga\project\config\Config::getDbPassword());

/* PHP DATE FORMAT DEFAULT */
define("PHP_DATE_FORMAT", "Y-m-d");
define("PHP_TIME_FORMAT", "H:i:s");
define("PHP_DATETIME_FORMAT", PHP_DATE_FORMAT . " " . PHP_TIME_FORMAT);

Perms::getInstance()->setConfig(new PermsConfig("cobrador-web", Config::getInteriorIssuerRealms()));

Factory::setStartupConfig(new GrayLoggerConfig("SG", Config::getGelfHost(), Config::getGelfPort(), Config::getLogLevel(), Config::getLogFile()));

set_error_handler([
				PHPLogger::class,
				"handleError" ]);
set_exception_handler([
				PHPLogger::class,
				"handleException" ]);