<?php
require_once "./components/".basename(__DIR__)."/controller.php";
class vinput_select_box extends view{
    function init($params=null){
        $template_name=isset($params['template']) ? $params['template'] : "default";
        $path=$_SERVER['DOCUMENT_ROOT'].'/components/'.basename(__DIR__).'/template/'.$template_name.'.php';
        $controller= new cinput_select_box();
        $arrResult= $controller->getData($params);

        /////сделал наследование тольк о что бы наследовать этот метод. Вообще-то это сильное зацепление
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