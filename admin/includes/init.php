<?php
if(defined('DS') == null) {  define('DS', DIRECTORY_SEPARATOR); }
defined('SITE_PATH') == null ?  define("SITE_PATH", dirname(getcwd())) : null;
defined('INCLUDES_PATH') == null ? define("INCLUDES_PATH", SITE_PATH . DS . "admin" . DS . "includes" . DS) : null ;

require_once "includes/n_config.php";
require_once "classes" . DS . "database.php";
require_once "classes" . DS . "db_object.php";
require_once "includes"  . DS . "functions.php";
require_once "classes" . DS . "session.php";

$session = new session();
?>