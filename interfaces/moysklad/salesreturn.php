<?php

class Salesreturn extends Entity
{
    public $fields;
    public function __construct($entity)
    {
        $this->fields=$this->getFields($entity);
    }

    function getFields($entity){
        $res=[];
        $res['name']=$this->getName($entity);
        $res['uri']=$this->getUri($entity);
        //$res['agent']=$this->getAgent($entity);
          $res['attributes']=$this->getAttributes($entity);
        //    $res['state']=$this->getState($entity);
       // $res['sfx']=$this->getSfx($entity);
        return $res;
    }
    function setSalesreturnrAttribute($id, $index, $value){
        $uri='https://online.moysklad.ru/api/remap/1.2/entity/salesreturn/metadata/attributes/';
        $json=$this->setAttribute($uri, $id, $index, $value);
        return $json;
    }
}