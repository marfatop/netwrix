<?php
require_once $_SERVER['DOCUMENT_ROOT']."/components/".basename(__DIR__)."/model.php";

class cpartners{

    function getData($params){
       // var_dump($params);
        $db=new mpartners();
        $sort=['field'=>$params['sort_field'], 'direction'=>$params['sort_direction']];
        $data=$db::selectRows($params['tbl'],$params['fields'], $params['condition'], $sort);
        //var_dump($data);
        if(empty($data['error'])){
            $res=$data;
        }
        else{
            $res=$this->getError($data);
            var_dump($res);
          //  throw new Exception($res);
            //var_dump($res);
        }

        return $res;
    }
    function getError($data){
        return $data;
    }
}
