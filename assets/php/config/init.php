<?php
session_start();
require_once 'config.php';
//autoload classes
function __autoload($classname)
{
    require_once 'lib/' . $classname . '.php';
}