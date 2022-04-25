<?php
require_once 'connectDBOracle.php';
require_once 'constans_conf.php';
date_default_timezone_set('Asia/Bangkok');

$currentMounth = date("m");
$currentyear = date("Y");

$maxYear = $currentMounth >= $startBudgetMounth ? $currentyear : $currentyear-1;

$sql = '';

for ($i=$startYear; $i <= $maxYear; $i++) { 
  
  $thaiYear = $i + 543;
  // $headString = 'budget' . substr($thaiYear, strlen($thaiYear)-2, 2);
  $YY = substr($i, strlen($i)-2, 2);
  
  $sql .= $i != $startYear ? 'UNION' : '';

  $sql .= " SELECT * FROM (
    SELECT DISTINCT '{$thaiYear}' AS HEADYEAR, JVN_ID, NVL2(CTRL_STATUS,CTRL_STATUS,0) AS stat FROM VDTL_CMST_CASE_MAIN_HD2 
    WHERE RECEIVE_DATE BETWEEN to_date('01-OCT-{$YY}', 'DD-MONTH-YY') 
    AND to_date(TO_CHAR ((ADD_MONTHS ('01-OCT-{$YY}',12) - 1), 'YYYY-MM-DD') || ' 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
  )
  PIVOT(
      COUNT(JVN_ID) 
      FOR stat
      IN ( 
          'N' N,
          'Y' Y,
          0 NLL
      )
  ) ";

}

$results = $pdo->prepare($sql);  
$results->execute();
$getData = $results->fetchAll(PDO::FETCH_OBJ);

$pdo = null;
echo json_encode($getData);