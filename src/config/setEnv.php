<?php
namespace braga\project\config;
/**
 * Created on 22 sty 2018 10:39:20
 * error prefix
 * @author Tomasz Gajewski
 * @package
 *
 */
use braga\db\ConnectionConfiguration;
use braga\db\mysql\DB;
use braga\graylogger\Factory;
use braga\graylogger\GrayLoggerConfig;
use braga\project\base\Perms;
use braga\project\base\PermsConfig;
use braga\project\utils\logger\BenchmarkLogger;
use braga\project\utils\logger\PHPLogger;
use braga\tools\benchmark\Benchmark;
use Monolog\Level;
Benchmark::init(BenchmarkLogger::class);
mb_internal_encoding("utf8");
ini_set("max_execution_time", "1800");
date_default_timezone_set("Europe/Warsaw");

if(file_exists(__DIR__ . "/devEnv.php"))
{
	require_once __DIR__ . "/devEnv.php";
}

/* DB CONFIGURACTION */
define("DB_SCHEMA", Config::getDbSchema());

/* PHP DATE FORMAT DEFAULT */
define("PHP_DATE_FORMAT", "Y-m-d");
define("PHP_TIME_FORMAT", "H:i:s");
define("PHP_DATETIME_FORMAT", PHP_DATE_FORMAT . " " . PHP_TIME_FORMAT);

Perms::getInstance()->setConfig(new PermsConfig(Config::getClientId(), Config::getIssuerRealms()));
DB::setConnectionConfigration(new ConnectionConfiguration(Config::getDbConnectionString(), Config::getDbUser(), Config::getDbPassword(), "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_polish_ci'"));
Factory::setStartupConfig(new GrayLoggerConfig("XX", Config::getGelfHost(), Config::getGelfPort(), Level::fromName(Config::getLogLevel()), Config::getLogFile()));

set_error_handler([
				PHPLogger::class,
				"handleError" ]);
set_exception_handler([
				PHPLogger::class,
				"handleException" ]);