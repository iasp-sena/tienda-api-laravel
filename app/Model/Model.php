<?php


namespace App\Model;

use App\Helpers\StringHelper;


abstract class Model extends \Illuminate\Database\Eloquent\Model
{

    public function toArray()
    {
        $array = parent::toArray();
        $camelArray = array();
        foreach($array as $name => $value){
            $camelArray[StringHelper::toLowerCamelCase($name)] = $value;
        }
        return $camelArray;
    }

}