# CakePHP2 Assessment

## features
6 Questions [CakePHP, JS, AJAX, MySQL]

## environment
PHP 5.6.40-47+ubuntu20.04.1+deb.sury.org+1 (cli)  
MySQL Ver 14.14 Distrib 5.7.28, for Linux (x86_64)  
ubuntu20.04.1+deb.sury.org+1 (cli)  

## configure database in /app/config/database.php

class DATABASE_CONFIG {

	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' 		 => 'localhost',
		'login'      => '',
		'password'   => '',
		'database'   => '',
		'prefix'     => '',
		'encoding'   => 'utf8',
	);
}

## Additional package
composer require shuchkin/simplexlsx

## deploy development server
/app/Console/cake server

<img src="../submission/screenshots/questions.PNG" width="60%">
