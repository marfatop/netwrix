<?php
require_once $_SERVER['DOCUMENT_ROOT']."/components/".basename(__DIR__)."/controller.php";
class vpartners extends view{
    function init($params=null){
        $template_name=isset($params['template']) ? $params['template'] : "default";
        $path=$_SERVER['DOCUMENT_ROOT'].'/components/'.basename(__DIR__).'/template/'.$template_name.'.php';

        $controller= new cpartners();
        $arrResult= $controller->getData($params);
        /////сделал наследование только что бы наследовать метод chkFile. Вообще-то это сильное зацепление
        if($this->chkFile($path)){
            ob_start();
            require $path;
            $template=ob_get_clean();
        }
        else{
            $template='Error no component: ' .basename(__DIR__). '; template: '. $template_name.PHP_EOL.$path;
        }
        return $template;
    }

}