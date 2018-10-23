<?php
/**
 * Created by PhpStorm.
 * User: benjaminrobinet
 * Date: 09/10/2018
 * Time: 10:28
 */

namespace Sweart;

use PDO;

class Query
{
    private $sqltable;
    private $fields = '*';
    private $where = '';
    private $args = [];
    private $sql = '';

    public static function table(string $table){
        $query = new Query;
        $query->sqltable = $table;
        return $query;
    }

    public function select(array $fields){
        $this->fields = implode(',', $fields);
        return $this;
    }

    public function where(string $col, string $op, $val){
        $where = "`$col` $op ?";
        $this->args[] = $val;

        $this->where = (!empty($this->where) ? $this->where . ' AND ' . $where : 'WHERE ' . $where);
        return $this;
    }

    public function get(){
        try {
            $db = ConnectionFactory::getConnection();
        } catch (\Exception $e) {
            die($e);
        }

        $this->sql = "SELECT $this->fields FROM $this->sqltable $this->where";
        $stmt = $db->prepare($this->sql);
        $stmt->execute($this->args);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function delete(){
        try {
            $db = ConnectionFactory::getConnection();
        } catch (\Exception $e) {
            die($e);
        }

        $this->sql = "DELETE FROM $this->sqltable $this->where";

        $stmt = $db->prepare($this->sql);
        return $stmt->execute($this->args);
    }

    public function insert(array $data){
        try {
            $db = ConnectionFactory::getConnection();
        } catch (\Exception $e) {
            die($e);
        }

        $this->args = array_values($data);
        $keys = implode(',', array_keys($data));

        $values = rtrim(str_repeat('?,', sizeof($data)), ',');

        $this->sql = "INSERT INTO $this->sqltable ($keys) VALUES ($values)";

        $stmt = $db->prepare($this->sql);
        $stmt->execute($this->args);

        return $db->lastInsertId($this->sqltable);
    }
}