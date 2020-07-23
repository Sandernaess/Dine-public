<?php
class mysqlPDO extends PDO {
  public function __construct() {
    $drv = 'mysql';
    $hst = 'xxx'; 
    $usr = 'xxx';
    $pwd = 'xx';
    $sch = 'Dine';
    $dsn = $drv . ':host=' . $hst . ';dbname=' . $sch;
  parent::__construct($dsn,$usr,$pwd);
  }
}
$db = new mysqlPDO();
$salt = "D2020"; 
$dbName = "Dine"; 
?>