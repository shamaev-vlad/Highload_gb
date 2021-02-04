<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('vendor/autoload.php');
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


$time_start = time ();

function req(){
    echo 1;
    req();
}
req();

$time_end = time ();

$log = new Logger('time');
$log->debug(memory_get_usage());
$log->pushHandler(new StreamHandler('log/time.log', Logger::DEBUG));
$log->debug($time_end - $time_start);
