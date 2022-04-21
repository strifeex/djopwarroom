<?php
  $host = '10.222.14.11';
  $db_username = "djopprd";
  $db_password = "Djopprd#01";
  $sid = 'eservice';
  $port = '1521';

  $tns = " 
  (DESCRIPTION =
      (ADDRESS_LIST =
        (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port))
      )
      (CONNECT_DATA =
        (SID=$sid)
      )
  )
  ";

  try{
    $pdo = new PDO("oci:dbname=$tns ;charset=UTF8",$db_username,$db_password);
    
  }catch(PDOException $e){
      echo ($e->getMessage());
  }
?>