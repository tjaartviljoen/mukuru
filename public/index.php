<?php
//-- Decline static file requests back to the PHP built-in web-server.
if (php_sapi_name() === 'cli-server'
    && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))
)
{
	return false;
}

//-- Relativity to root.
chdir(dirname(__DIR__));

//-- Timezone.
date_default_timezone_set('Africa/Johannesburg');

//-- Establish environment.
$isDevEnv = ('development' == getenv('APPLICATION_ENV') || 'nrad.local' == php_uname("n"));
define('IS_DEV_ENV', $isDevEnv);

//-- Setup auto-loading.
require 'init_autoloader.php';

//-- Run the application.
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
