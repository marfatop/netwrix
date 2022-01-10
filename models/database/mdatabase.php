<?php
require_once 'config.php';
class MDatabase
{
    private static $instance, $arr_connect;
    public static $DBH;

    private function __construct()
    {
        $db_log = ['host' => DBHOST, 'user' => DBUSER, 'pass' => DBPAS, 'db_name' => DBNAME];

        static::$arr_connect=$db_log;

        self::connect();
    }

    public function __destruct()
    {
       self::disconnect();
    }

    // паттерн создания синглтона
    public static function getInstance(): self
    {
        if (is_null(static::$instance)) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    private static function connect ()
    {
        try{
            $host = static::$arr_connect [ 'host' ];
            $db   = static::$arr_connect [ 'db_name' ];
            $user = static::$arr_connect [ 'user' ];
            $pass = static::$arr_connect [ 'pass' ];
            $charset = 'utf8';

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $opt = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            self::$DBH = new PDO($dsn, $user, $pass, $opt);


        }
        catch(PDOException $e) {
            self::$DBH= $e->getMessage();
        }
    }


     static function disconnect ()
    {
        self::$DBH = null;
    }

    public static function selectUniqRows($tbl, $colums, $conditions=null, $sort=null){
        $w=!empty($conditions) ? ' WHERE '.implode(" ",$conditions) : null;
        $s=!empty($sort) ? ' ORDER BY '.$sort['field'] .' '.$sort['direction']  : null;
        $q='SELECT DISTINCT '.implode(",",$colums). ' FROM '.$tbl.'  '.$w .$s ;

        $stm=self::$DBH->prepare($q);
        $stm->execute();

        try {
            $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            $data['error'] = $e->getMessage();
            $data['sql']=$q;
            file_put_contents('PDOErrors.txt', $e->getMessage().PHP_EOL, FILE_APPEND);
        }
        return $data;
    }


    public static function selectRows($tbl, $colums, $conditions=null, $sort=null){
        $w=!empty($conditions) ? ' WHERE '.implode(" ",$conditions) : null;
        $s=!empty($sort) ? ' ORDER BY '.$sort['field'] .' '.$sort['direction']  : null;
        $q='SELECT '.implode(",",$colums). ' FROM '.$tbl.'  '.$w .$s ;

        $stm=self::$DBH->prepare($q);
        $stm->execute();

        try {
            $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            $data['error'] = $e->getMessage();
            $data['sql']=$q;
            file_put_contents('PDOErrors.txt', $e->getMessage().PHP_EOL, FILE_APPEND);
        }

        return $data;
    }

}