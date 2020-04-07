<?php
session_start();
require_once 'config.php';

require_once 'helpers/system_helper.php';
//autoload classes
function __autoload($classname)
{
    require_once 'lib/' . $classname . '.php';
}