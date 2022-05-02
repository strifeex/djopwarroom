<?php
$host = "10.222.13.18";
$username = 'root';
$password = 'pse8m3';
$database = 'login';

try{
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->exec("set names utf8");
}
catch(PDOException $e)	{
    //$e->getMessage();
    $resmsg= 'เชื่อมต่อฐานข้อมูลไม่ได้';
    echo json_encode($resmsg);
    exit();
}
?>