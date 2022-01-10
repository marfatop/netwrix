<?php
require_once $_SERVER['DOCUMENT_ROOT']."/components/".basename(__DIR__)."/view.php";
$GLOBALS['scripts'][]="components/".basename(__DIR__)."/script.js";
$view=new vdata_select_box();
$html=$view->init($params);
?>
<?=$html?>
