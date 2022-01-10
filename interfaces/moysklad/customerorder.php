<?php


class Customerorder extends Entity
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
        $res['agent']=$this->getAgent($entity);
        $res['attributes']=$this->getAttributes($entity);
        $res['state']=$this->getState($entity);

        return $res;
    }
    function setCustomerorderState($id){
        $uri='https://online.moysklad.ru/api/remap/1.2/entity/customerorder/metadata/states/';
        $json=$this->setState($uri, $id);
        return $json;
    }
    function setCustomerorderAttribute($id, $index, $value){
        $uri='https://online.moysklad.ru/api/remap/1.2/entity/customerorder/metadata/attributes/';
        $json=$this->setAttribute($uri, $id, $index, $value);
        return $json;
    }
    function updCustomerOrder($uri, $data){
        $json=json_encode($data);

    }

}