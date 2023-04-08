<?php
namespace braga\project\config;
Config::putenv("DBCONNECTIONSTRING", "mysql:host=localhost");
Config::putenv("DBSCHEMA", "project");
Config::putenv("DBUSER", "root");
Config::putenv("DBPASS", "root");
Config::putenv("ISSUERREALMS", "https://auth.rubycon.info/auth/realms/interior");
Config::putenv("GELF_HOST", "");
Config::putenv("GELF_PORT", "");
Config::putenv("LOG_LEVEL", "DEBUG");
Config::putenv("LOG_FILE", "" . __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "log\\%s_%s.log");
Config::putenv("AUTH_CLIENT_ID", "project");
Config::putenv("AUTH_CLIENT_SECRET", "");