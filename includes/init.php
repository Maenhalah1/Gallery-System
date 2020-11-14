<?php
date_default_timezone_set("Asia/Amman");
if(defined('DS') == null) {  define('DS', DIRECTORY_SEPARATOR); }
defined('SITE_PATH') == null ?  define("SITE_PATH", dirname(getcwd())) : null;
defined('INCLUDES_PATH') == null ? define("INCLUDES_PATH", SITE_PATH . DS . "admin" . DS . "includes" . DS) : null ;

require_once "admin/includes/n_config.php";
require_once "admin" . DS . "classes" . DS . "database.php";
require_once "admin" .  DS . "classes" . DS . "db_object.php";
require_once "admin" . DS . "classes" . DS . "session.php";
require_once "includes"  . DS . "functions.php";

require_once "admin" . DS . "classes" . DS . "photo.php";
require_once "admin" . DS . "classes" . DS . "users.php";
require_once "admin" . DS . "classes" . DS . "comment.php";

$session = new session();
?>