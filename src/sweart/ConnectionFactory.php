<?php
/**
 * Created by PhpStorm.
 * User: benjaminrobinet
 * Date: 09/10/2018
 * Time: 11:49
 */

namespace Sweart;


use PDO;

class ConnectionFactory
{
    private static $db;

    /**
     * @param array $conf
     * @throws \Exception
     */
    public static function makeConnection(array $conf){
        $search = ['username', 'password', 'host', 'database'];

        foreach ($search as $key){
            if(!array_key_exists($key, $conf)){
                throw new \Exception('Check your configuration.');
            }
        }

        $dsn = 'mysql:host=' . $conf['host'] . ';dbname=' . $conf['database'] . '';
        $username = $conf['username'];
        $password = $conf['password'];

        try{
            static::$db = new PDO($dsn, $username, $password, [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_STRINGIFY_FETCHES => false

            ]);
        } catch (\PDOException $e){
            die($e);
        }

        return static::$db;
    }

    /**
     * @return PDO
     * @throws \Exception
     */
    public static function getConnection(){
        if(isset(static::$db)){
            return static::$db;
        } else {
            throw new \Exception('The connection doesn\'t exists, use makeConnection(array $conf) first.');
        }
    }
}