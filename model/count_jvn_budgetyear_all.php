<?php
require_once 'connectDBOracle.php';

$sql = file_get_contents('count_jvn_budgetyear_all.sql', true);

$results = $pdo->prepare($sql);  
$results->execute();
$getData = $results->fetchAll(PDO::FETCH_OBJ);

$pdo = null;
echo json_encode($getData);