<?php
require __DIR__.'/vendor/autoload.php';
date_default_timezone_set("Europe/Berlin");

use Src\System\DatabaseConnector;
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if($_ENV['debug']== "true"){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

putenv("LD_LIBRARY_PATH=test");
new DatabaseConnector();
