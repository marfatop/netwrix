<?php

class view
{
    function display($layout, $template=null){
        $data=$this->getTemplate($layout, $template);
        return $data;
    }

    function getTemplate($layout, $template=null){

        $view=$this;

        $file=isset($template) ? $template : 'default';
        $path=$_SERVER['DOCUMENT_ROOT'].'/templates/'.$layout.'/'.$file.'.php';

        if($this->chkFile($path)){
            ob_start();
            require $path;
            $data=ob_get_clean();
        }
        else{
            ob_start();
            require $_SERVER['DOCUMENT_ROOT'].'/templates/default/default.php';
            $data=ob_get_clean();
        }
        return $data;
    }

    function showComponent($component, $params=null){
        $path=$_SERVER['DOCUMENT_ROOT'].'/components/'.$component.'/component.php';
        if($this->chkFile($path)){
            ob_start();
            require $path;
            $component=ob_get_clean();
        }
        else{

            $component='Error no component '. $component;
        }
        return $component;
    }

//    function getLastData(){
//        $html='';
//        $file=$_SERVER['DOCUMENT_ROOT'].'/inputdata.log';
//        if($this->chkFile($file)){
//            $data=file_get_contents($file);
//        }
//        else{
//            $data='No LastData';
//        }
//        $html.="<section>";
//        $html.="<h1>Последние данные</h1>";
//        $html.="<div>";
//        $html.=$data;
//        $html.="</div>";
//        $html.="</section>";
//
//        return $html;
//    }
//    function getDataError(){
//        $file=$_SERVER['DOCUMENT_ROOT'].'/error.log';
//        if($this->chkFile($file)){
//            $data=file_get_contents($file);
//        }
//        else{
//            $data='No LastData';
//        }
//        return $data;
//    }
//    function getReports(){
//        $file=$_SERVER['DOCUMENT_ROOT'].'/templates/reports/default.php';
//        if($this->chkFile($file)){
//            ob_start();
//            require $file;
//            $data=ob_get_clean();
//        }
//        else{
//            $data='No LastData';
//        }
//        return $data;
//    }
//    function getTemplateConfig(){
//        $file=$_SERVER['DOCUMENT_ROOT'].'/templates/config/default.php';
//        if($this->chkFile($file)){
//
//            ob_start();
//            require $file;//file_get_contents($file);
//            $data=ob_get_clean();
//        }
//        else{
//            $data='No LastData';
//        }
//        return $data;
//    }
    function chkFile($path){
        return file_exists($path);
    }
}