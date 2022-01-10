<?php

include  $_SERVER['DOCUMENT_ROOT']."/models/moysklad/mmoysklad.php";
include  $_SERVER['DOCUMENT_ROOT']."/config.php";

//echo 'ghbdtn';

$res=GetInput();

echo json_encode($res);

function GetInput()
{
    if(!empty($_REQUEST))
    {
        if(function_exists($_REQUEST['task']))
        {   $filter=filter_input_array(INPUT_GET, $_GET);
            unset($filter['task']);
            return call_user_func($_REQUEST['task'],$filter);
        }
    }
}

function getAllOrders(){
    $moysklad= new MMoySklad();
    $offset=0;
    $limit=100;
    $expand='?limit='.$limit.'&offset='.$offset.'&expand=agent';
    $query="https://online.moysklad.ru/api/remap/1.2/entity/customerorder/";
    $arrOrders=$moysklad->getRequest($query.$expand);
    $counter=$arrOrders['meta']['size'];
    $arrOrders_r=$arrOrders['rows'];
    while ($offset<$counter){
        $offset=$offset+$limit;
        $expand2='?limit='.$limit.'&offset='.$offset.'&expand=agent';
        $arrOrders2=$moysklad->getRequest($query.$expand2);
        $arrOrders_r=array_merge($arrOrders_r,$arrOrders2['rows']);
    }
    $arr_sum=[];

    $c=0;
    foreach ($arrOrders_r as $index => $row) {

        $c++;
        $y=date("Y", strtotime($row['moment']));
        $m=date("m", strtotime($row['moment']));
        $arr_month[$m]=$m;
        $arr[$y][$m][]=$row;
        $order_sum=($row['sum']/100);

        //покупатели помесяцам
        $arr2[$y][$m][$row['agent']['name']]['sum']=$arr2[$y][$m][$row['agent']['name']]['sum']+$order_sum;
        $arr2[$y][$m][$row['agent']['name']]['counter']+=1;
        ///выручка помесяцас
        $arr_sum[$m]=$arr_sum[$m]+$order_sum;
        $s=isset($arr3[$row['agent']['name']][$m]['sum']) ? $arr3[$row['agent']['name']][$m]['sum'] : 0;
        $arr3[$row['agent']['name']][$m]['sum']=ceil($s+$order_sum);
    }
    $i=0;
    $i2=1;
    $arr6[0]['name']='other';
    $sum_other=[];
    foreach ($arr3 as $index => $agent) {
        $arr5[$i]['name']=$index;
        $arr6[$i2]['name']=$index;
        $indx=0;
        foreach ($arr_month as $index2 => $month) {
            $indx=((int)$month-1);
            if($agent[$month]['sum']<=200000){
                $sum_other[$indx]=$sum_other[$indx]+$agent[$month]['sum'];
                $arr6[$i2]['data'][]=0;
            }
            else{
                $arr6[$i2]['data'][]= $arr3[$index][$month]['sum'];
            }
            $arr5[$i]['data'][]=isset($arr3[$index][$month]['sum']) ? $arr3[$index][$month]['sum'] : 0;
        }
        if(!empty($sum_other)){
            ksort($sum_other);
            $arr6[0]['data']=$sum_other;
        }
        $i++;
        $i2++;
    }

//    foreach ($arr_month as $index => $item) {
//        $arr3[$row['agent']['name']][$item]['sum'] = !isset($arr3[$row['agent']['name']][$item]['sum']) ? "0" : $arr3[$row['agent']['name']][$item]['sum'] ;
//
//    }



//    foreach ($arr['2021'] as $index => $item) {
//
//        $sum=array_map(function ($row){return ceil($row['sum']/100);},$item);
//
//        $arr_sum[$index]=array_sum($sum);
//    }
    $arResult['meta_orders']=$arrOrders['meta'];
    $arResult['orders']=$arr;
    $arResult['sum']=$arr_sum;
    $arResult['agent']=$arr2;
    $arResult['agent2']=$arr5;
    $arResult['agent3']=$arr6;

    return $arResult;
}
