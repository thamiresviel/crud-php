<?php

/** O nome do banco */
define('DB_NAME', 'wda_crud');

/** Usuario do banco */
define('DB_USER','root');

/** senha do banco */
define('DB_PASSWORD', '');

/** nome do host */
define('DB_HOST', 'localhost');

/** caminho absoluto para a pasta do sistema */
if(!defined('ABSPATH'))
    define('ABSPATH', dirname(__FILE__).'/');

/** CAMINHO NO SERVER  */
if(!defined('BASEURL'))
    define('BASEURL', '/CRUD-PHP-BOOTSTRAP/');

/** caminho do arquivo de banco de dados */
if(!defined('DBAPI'))
    define('DBAPI', ABSPATH.'inc/database.php');