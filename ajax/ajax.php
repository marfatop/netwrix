<?php
require_once "../view.php";
require_once "../models/database/mdatabase.php";


$requset_method=$_SERVER['REQUEST_METHOD'];

$res=GetInput($requset_method);
//поставить искуссвенную задержку для отображения лоадера на фронте
sleep(2);
echo json_encode($res);
exit();

//получить данные из AJAX запроса
function GetInput($requset_method)
{
    ;
    if($requset_method==='POST'){
        $res= Post();
    }
    elseif($requset_method==='GET'){
        $res= 'get';
    }
    else{
        $res['error']=[
            'msg'=>'Неверный запрос'
        ];
    }
    return $res;
}

function Post(){
    $res=$_SERVER;
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

    if ($contentType === "application/json") {

        $content = trim(file_get_contents("php://input"));

        $decoded = json_decode($content, true);

        if(! is_array($decoded)) {
            $res['error']=$decoded;
        } else {
                if(function_exists($decoded['task']))
                {
                    $filter=$decoded['data'];

                    $res=call_user_func($decoded['task'],$filter);
                }
        }
    }
    return $res;
}

function Get(){
    $res=[];
    if(!empty($_REQUEST))
    {
        if(function_exists($_REQUEST['task']))
        {   $filter=filter_input_array(INPUT_GET, $_GET);
            unset($filter['task']);
            $res= call_user_func($_REQUEST['task'],$filter);
        }
    }

    return $res;
}


//получить HTML код компонента для вывода
function getComponentPartner($data){

    $view = new View();
    $condition=[];
    if(!empty($data)){
        foreach ($data as $index => $item) {

            if(!empty($item)){
                $sfx=((sizeof($data))>1 && ($index+1<sizeof($data))) ? $item['sfx'] : null;

                $condition[]=$item['column']." LIKE '%".$item['data']."%' ".$sfx;
            }
        }
    }

    $params=[
        'tbl'=>'partner_locator',
        'fields'=>['*'],
        'sort_field'=>'company',
        'sort_direction'=>'asc',
        'condition'=>$condition,
    ];

    $res['componet']= htmlspecialchars_decode($view->showComponent('partners',$params));
    return $res;
}

//получить HTML код компонента для вывода
function getComponentSelectBox($data){

    $view = new View();
    $condition=[];
    if(!empty($data)){
        foreach ($data as $index => $item) {
            $sfx=count($data)!=($index+1) ? ' AND ' : null;
            if(!empty($item)){
                $condition[]=$item['column']." LIKE '%".$item['data']."%'".$sfx;
            }
        }
    }

     $params=[
                'tbl'=>'loc_state',
                'fields'=>['name', 'short_name'],
                'sort_field'=>'name',
                'sort_direction'=>'asc',
                'condition'=>$condition,
                'template'=>'states',
                'disabled'=>false
            ];
    $res['componet']= htmlspecialchars_decode($view->showComponent('data_select_box',$params));
    return $res;
}
