<?php
require_once $_SERVER['DOCUMENT_ROOT']."/components/".basename(__DIR__)."/view.php";

$view=new vpartners();
$html=$view->init($params);

?>

<?=$html?>
