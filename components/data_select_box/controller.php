<?php
require_once $_SERVER['DOCUMENT_ROOT']."/components/".basename(__DIR__)."/model.php";

class cdata_select_box{

    function getData($params){
       // var_dump($params);
        $db=new mdata_select_box();
        $sort=['field'=>$params['sort_field'], 'direction'=>$params['sort_direction']];
        $data=$db::selectUniqRows($params['tbl'],$params['fields'], $params['condition'], $sort);

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
