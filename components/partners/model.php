<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/models/database/mdatabase.php';
class mpartners extends mdatabase{
    public function __construct()
    {
        return parent::getInstance();
    }
}