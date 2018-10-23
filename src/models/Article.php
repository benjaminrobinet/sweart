<?php
/**
 * Created by PhpStorm.
 * User: benjaminrobinet
 * Date: 16/10/2018
 * Time: 09:58
 */

namespace Models;


use Sweart\Model;

class Article extends Model
{
    protected static $table = 'article';
    protected static $primaryKey = 'id';

    public function categorie(){
        return $this->belongsTo("\\Models\Categorie", 'id_categ');
    }
}