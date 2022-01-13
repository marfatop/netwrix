<?php
//require_once $_SERVER['DOCUMENT_ROOT']."/components/".basename(__DIR__)."/model.php";
require_once $_SERVER['DOCUMENT_ROOT']."/components/input_select_box/model.php";
class cinput_select_box{

    function getData($params){
  //      var_dump($params);
        $db= minput_select_box::getInstance();
        $sort=['field'=>$params['sort_field'], 'direction'=>$params['sort_direction']];
        $data=$db::selectUniqRows($params['tbl'],$params['fields'], $params['condition'], $sort);
//var_dump($data);
        if(empty($data['error'])){
            $res=$data;
        }
        else{
            $res=$this->getError($data);
            var_dump($res);
            throw new Exception($res);
            //var_dump($res);
        }

        return $res;
    }
    function getError($data){
        return $data;
    }
}
