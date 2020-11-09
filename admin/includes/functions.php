<?php

// this function use to auto loading class from classes dirctory that is not inistization in project
function autoloadclass($class){
    $class = strtolower($class);
    $path = "classes" . DS . $class . ".php";
    if (file_exists($path) && !class_exists($class)) {
        require_once($path);
    } else if (!file_exists($path)) {
        die ("sorry, {$class} class is not found");
    }

}
spl_autoload_register('autoloadclass');

function Redirect($url) {
    header("Location:{$url}");
}
?>
