<?php
require_once $_SERVER['DOCUMENT_ROOT']."/view.php";
//require_once $_SERVER['DOCUMENT_ROOT']. "/components/data_select_box/model.php";


$requset_method=$_SERVER['REQUEST_METHOD'];

$res=GetInput($requset_method);
//поставить искуссвенную задержку для отображения лоадера на фронте
//sleep(1);
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

function getComponentPartner($data){

    $res['data']['input']=$data;

    $data_input=current($data);
    $condition=[];
    $size=sizeof($data);
    foreach ($data as $index => $row) {
        if(!empty($row['data'])) {
            if ($index > 0 && $index != ($size - 1)) {
                $condition[] = $row['column'] . " LIKE '%" . $row['data'] . "%' " . $row['sfx'] . " ";
            } elseif ( $index === 0 && $size > 1) {
                $condition[] = $row['column'] . " LIKE '%" . $row['data'] . "%' " . $row['sfx'] . " ";
            } else {
                $condition[] = $row['column'] . " LIKE '%" . $row['data'] . "%' ";
            }
        }

    }


    $view=new view();
     $params = [
            'tbl' => 'partner_locator',
            'fields' => ['*'],
            'sort_field' => 'company',
            'sort_direction' => 'asc',
            'condition'=>$condition,
            //  'template'=>''
        ];
        $res['data']['params']=$params;

        $res['data']['componet']= $view->showComponent('partners', $params);

    return $res;
}

function getComponentSelectBox($data){
    //$res['data']=$data;
    $view=new view();
      $params = [
                    'tbl' => 'loc_state',
                    'fields' => ['name', 'short_name'],
                    'sort_field' => 'name',
                    'sort_direction' => 'asc',
                    'condition' => [$data[0]['column']." = '".$data[0]['data']."'"],
                    'template' => 'states',
                    'disabled' => false
                ];
        $res['data']['param']=$params;
      $res['data']['componet'] =$view->showComponent('data_select_box', $params);

    return $res;
}