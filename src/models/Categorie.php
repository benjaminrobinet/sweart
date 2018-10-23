<?php
/**
 * Created by PhpStorm.
 * User: benjaminrobinet
 * Date: 23/10/2018
 * Time: 10:52
 */

namespace Models;


use Sweart\Model;

class Categorie extends Model
{
    protected static $table = 'categorie';
    protected static $primaryKey = 'id';

    public function articles(){
        return $this->hasMany("\\Models\Article", 'id_categ');
    }
}