<?php
/**
 * Created by PhpStorm.
 * User: benjaminrobinet
 * Date: 16/10/2018
 * Time: 09:30
 */

namespace Sweart;

abstract class Model
{
    protected $model = [];
    protected static $table;
    protected static $primaryKey = 'id';

    public function __construct($data = [])
    {
        $this->model = $data;
    }

    /**
     * Insert model in database
     */
    public function insert(){
        $query = new Query();
        $insertedId = $query::table(static::$table)->insert($this->model);
        $this->model[static::$primaryKey] = $insertedId;
    }

    /**
     * @return array List of all without any condition models found in database
     */
    public static function all(){
        $query = new Query();
        $data = $query::table(static::$table)->select(['*'])->get();

        return static::arrayToModels($data);
    }

    /**
     * @param array $conds Conditions in format [[what, op, val],[...]]
     * @param array $cols Columns to select
     * @return array List of all corresponding models found in database
     */
    public static function find($conds = [], array $cols = ['*']){
        $query = new Query();
        $req = $query::table(static::$table)->select($cols);

        if(is_array($conds)){
            if(is_array($conds[0])){
                foreach ($conds as $cond){
                     $req->where($cond[0], $cond[1], $cond[2]);
                }
            } else {
                $req->where($conds[0], $conds[1], $conds[2]);
            }
        } else {
                $req->where(static::$primaryKey, '=', $conds);
        }

        $data = $req->get();

        return static::arrayToModels($data);
    }

    /**
     * @param array $conds Conditions in format [[what, op, val],[...]]
     * @param array $cols Columns to select
     * @return Model The first corresponding model found in database
     */
    public static function first($conds = [], array $cols = ['*']){
        $resp = static::find($conds, $cols);
        if(!empty($resp)){
            return $resp[0];
        } else {
            return [];
        }
    }

    /**
     * @return bool true if query executed correctly
     */
    public function delete(){
        $query = new Query();
        return $query::table(static::$table)->where(static::$primaryKey, '=', $this->model[static::$primaryKey])->delete();
    }

    /**
     * @param $model Model of which it is belonging to
     * @param $foreignKey The foreign key in the database
     * @return Model The model of which it is belonging to
     */
    public function belongsTo($model, $foreignKey){
        /** @var Model $model */
        return $model::first([$model::$primaryKey, '=', $this->model[$foreignKey]]);
    }

    /**
     * @param $model Models of which it has many
     * @param $foreignKey The foreign key in the database
     * @return array Models of which it has many
     */
    public function hasMany($model, $foreignKey){
        /** @var Model $model */
        return $model::find([$foreignKey, '=', $this->model[static::$primaryKey]]);
    }

    /**
     * @param array $array
     * @return array Array of models
     */
    private static function arrayToModels(array $array){
        $models = [];
        foreach ($array as $modelArray){
            $models[] = new static($modelArray);
        }

        return $models;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        try{
            if(array_key_exists($name, $this->model)){
                return $this->model[$name];
            } else {
                if(method_exists($this, $name)){
                    return $this->{$name}();
                } else {
                    throw new \Exception($name . ' doesn\'t exists in the Model ' . get_class($this));
                }
            }
        } catch (\Exception $e){
            die($e->getMessage());
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->model[$name] = $value;
    }
}