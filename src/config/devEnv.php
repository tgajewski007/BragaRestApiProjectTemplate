<?php
if(getenv("DBCONNECTIONSTRING") === false)
{
	putenv("DBCONNECTIONSTRING=mysql:host=192.168.0.15");
}
if(getenv("DBSCHEMA") === false)
{
	putenv("DBSCHEMA=restapi");
}
if(getenv("DBUSER") === false)
{
	putenv("DBUSER=root");
}
if(getenv("DBPASS") === false)
{
	putenv("DBPASS=1");
}
if(getenv("LOG4PHPCONFIGFILE") === false)
{
	putenv("LOG4PHPCONFIGFILE=o:\\wwwroot\\PiechockiServicesEsb\\loggerConfig.xml");
}
if(getenv("ISSUERREALMS") === false)
{
	putenv("ISSUERREALMS=https://auth.rubycon.info/auth/realms/interior");
}