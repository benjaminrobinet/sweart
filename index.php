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

use \Sweart\ConnectionFactory;

$conf = parse_ini_file('config/configuration.ini', true);

try {
    $db = ConnectionFactory::makeConnection($conf['database']);
} catch (Exception $e) {
    die($e->getMessage());
}

$category = \Models\Categorie::first(1);
echo '<h1>Catégorie</h1>';
echo '<pre>';
print_r($category);
echo '</pre>';
echo '<h1>Articles</h1>';
echo '<pre>';
print_r($category->articles);
echo '</pre>';
