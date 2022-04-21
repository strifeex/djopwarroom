<?php
require_once 'connectDBOracle.php';

$sql = "SELECT * FROM 
(SELECT DISTINCT JVN_ID, RECEIVE_YEAR, NVL2(CTRL_STATUS,CTRL_STATUS,0) AS stat 
FROM VDTL_CMST_CASE_MAIN_HD2 WHERE RECEIVE_YEAR >= 2560 ) 
PIVOT(
    COUNT(JVN_ID) 
    FOR stat
    IN ( 
        'N' N,
        'Y' Y,
         0 NLL
    )
)
ORDER BY RECEIVE_YEAR";

$results = $pdo->prepare($sql);  
$results->execute();
$getData = $results->fetchAll(PDO::FETCH_OBJ);

$pdo = null;
echo json_encode($getData);