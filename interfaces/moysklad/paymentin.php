<?php

class Paymentin extends Entity
{
    public $fields;

    public function __construct($entity)
    {
        $this->fields = $this->getFields($entity);
    }

    function getFields($entity)
    {
        $res = [];
        $res['name'] = $this->getName($entity);
        $res['uri'] = $this->getUri($entity);
        // $res['agent']=$this->getAgent($entity);
        //  $res['attributes']=$this->getAttributes($entity);
        //    $res['state']=$this->getState($entity);
        //   $res['sfx']=$this->getSfx($entity);
        return $res;
    }
}

