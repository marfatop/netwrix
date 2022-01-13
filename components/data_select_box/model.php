<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/models/database/mdatabase.php';

class mdata_select_box extends mdatabase{
    public function __construct()
    {
        return parent::getInstance();
    }
}