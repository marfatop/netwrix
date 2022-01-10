<?php

class Entity
{
    public $fields;
    public function __construct($entity)
    {
//        $this->fields=[
//            'type'=>!empty($entity) ? $this->getType($entity) : null,
//        ];
        return true;
    }

    function getType($entity){
        $res=!empty($entity['meta']['type']) ? $entity['meta']['type'] : null;
        return $res;
    }

    function getUri($entity){
        $res=!empty($entity['meta']['href']) ? $entity['meta']['href'] : null;
        return $res;
    }

    function getName($entity){
        $res=!empty($entity['name']) ? $entity['name'] : null;
        return $res;
    }

    function getMoment($entity){
        $res=!empty($entity['moment']) ? $entity['moment'] : null;
        return $res;
    }

    function getAgent($entity){
        $res=!empty($entity['agent']) ? $entity['agent'] : null;
        return $res;
    }
    function getAttributes($entity){
        $res=!empty($entity['attributes']) ? $entity['attributes'] : null;
        return $res;
    }

    function getState($entity){
        $res=!empty($entity['state']) ? $entity['state'] : null;
        return $res;
    }

    function getAttrubuteByID($id, $data){

        foreach ($data as $index => $datum) {
            if($datum['id']==$id){
                $res=$datum;
            }
        }
        return $res;
    }
    function setState($uri, $id){
        $arr = [
                    "meta" => [
                        "href" => $uri.$id,
                        "type" => "state",
                        "mediaType" => "application\/json"
                    ]
                ];
        return $arr;
    }
    function setAttribute($uri, $id, $index, $value){
        $data_attribute=[
            "meta"=> [
                "href"=>$uri.$id,
                "type"=> "attributemetadata",
                "mediaType"=> "application/json"
            ],
            $index => $value
        ];
        return $data_attribute;
    }
}