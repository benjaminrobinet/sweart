<?php

/**
 * Created by PhpStorm.
 * User: benjaminrobinet
 * Date: 09/10/2018
 * Time: 10:22
 */

require_once 'vendor/autoload.php';

function debug($var){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}

use \Sweart\Query;
use \Sweart\ConnectionFactory;

$conf = parse_ini_file('config/configuration.ini', true);

try {
    $db = ConnectionFactory::makeConnection($conf['database']);
} catch (Exception $e) {
    die($e->getMessage());
}
