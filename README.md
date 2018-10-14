# Braga RESTApi Project Template
Tepmplate project for Braga framework

devEnv.php
<?php
if(getenv("DBCONNECTIONSTRING") === false)
{
	putenv("DBCONNECTIONSTRING=mysql:host=localhost");
}
if(getenv("DBSCHEMA") === false)
{
	putenv("DBSCHEMA=schema");
}
if(getenv("DBUSER") === false)
{
	putenv("DBUSER=root");
}
if(getenv("DBPASS") === false)
{
	putenv("DBPASS=root");
}
if(getenv("LOG4PHPCONFIGFILE") === false)
{
	putenv("LOG4PHPCONFIGFILE=o:\\wwwroot\\Arve\\loggerConfig.xml");
}
if(getenv("ISSUERREALMS") === false)
{
	putenv("ISSUERREALMS=https://auth.rubycon.info/auth/realms/interior");
}