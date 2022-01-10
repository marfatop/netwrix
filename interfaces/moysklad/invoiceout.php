<?php

class Invoiceout extends Entity
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
      //  $res['attributes']=$this->getAttributes($entity);
    //    $res['state']=$this->getState($entity);
        $res['sfx']=$this->getSfx($entity);
        return $res;
    }

    function getSfx($entity){
        $id=$entity['id'];
        $sfx="";

       // if(!empty($entity['customerOrder']['invoicesOut'])) {
         if(sizeof($entity['customerOrder']['invoicesOut'])>1) {
            foreach ($entity['customerOrder']['invoicesOut'] as $index => $item) {
                if ($item['id'] === $id) {
                    $sfx = ($index + 1);
                }
            }
        }
        elseif (!empty($entity['invoicesOut'])){
            foreach ($entity['invoicesOut'] as $index => $item) {
                if ($item['id'] === $id) {
                    $sfx = ($index + 1);
                }
            }
        }
        return $sfx;
    }
}