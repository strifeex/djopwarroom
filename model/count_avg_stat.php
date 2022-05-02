<?php
require_once 'connectDBMaria.php';
require_once 'constans_conf.php';
// date_default_timezone_set('Asia/Bangkok');

// $currentMounth = date("m");
// $currentyear = date("Y");

// $year = $_GET['budgetyear'];
// $year = $_GET['budgetyear'];

$year = 2021;

$startdate = "$year-10-01";
$year++;
$enddate = "{$year}-09-30";

$sql = "select d.unit_lname as unit, avg(male) male,avg(female) female 
  from stat.stat s inner join login.division d 
  ON s.unit_id = d.unit_id 
  where statdate between '$startdate' and '$enddate'  
  GROUP BY unit order by unit;";

$results = $pdo->prepare($sql);  
$results->execute();
$getData = $results->fetchAll(PDO::FETCH_OBJ);

$pdo = null;
echo json_encode($getData);