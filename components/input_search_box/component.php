<?php
require_once $_SERVER['DOCUMENT_ROOT']."/components/".basename(__DIR__)."/view.php";
$GLOBALS['scripts'][]="components/".basename(__DIR__)."/script.js";
$view=new vinput_search_box();

$html=$view->init($params);
?>
<?=$html?>
