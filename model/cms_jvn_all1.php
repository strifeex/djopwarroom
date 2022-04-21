<?php
require_once 'Model/connectDBOracle.php';
function MMThai($MM){

		if($MM==1)
		{
			$MM_New = 'มกราคม';
		}else if($MM==2)
		{
			$MM_New = 'กุมภาพันธ์';
		}else if($MM==3)
		{
			$MM_New = 'มีนาคม';
		}else if($MM==4)
		{
			$MM_New = 'เมษายน';
		}else if($MM==5)
		{
			$MM_New = 'พฤษภาคม';
		}else if($MM==6)
		{
			$MM_New = 'มิถุนายน';
		}else if($MM==7)
		{
			$MM_New = 'กรกฎาคม';
		}else if($MM==8)
		{
			$MM_New = 'สิงหาคม';
		}else if($MM==9)
		{
			$MM_New = 'กันยายน';
		}else if($MM==10)
		{
			$MM_New = 'ตุลาคม';
		}else if($MM==11)
		{
			$MM_New = 'พฤศจิกายน';
		}else if($MM==12)
		{
			$MM_New = 'ธันวาคม';
		}
	return $MM_New;
}
$MM2[1]='01';
$MM2[2]='02';
$MM2[3]='03';
$MM2[4]='04';
$MM2[5]='05';
$MM2[6]='06';
$MM2[7]='07';
$MM2[8]='08';
$MM2[9]='09';
$MM2[10]='10';
$MM2[11]='11';
$MM2[12]='12';
	

function JVN_COUNT($pdo,$MM,$YYY) { 
$sql11 = "SELECT COUNT(ccm.CASE_NO) AS CASE_NO 
FROM CMST_CASE_MAIN ccm
	LEFT JOIN CMST_CASE_JUVENILE ccj ON ccm.CMST_CASE_MAIN_REF =ccj.CMST_CASE_MAIN_REF 
            WHERE TO_CHAR(ccj.RECEIVE_DATE, 'MM')='$MM' AND TO_CHAR(ccj.RECEIVE_DATE, 'YYYY')='$YYY' ";	
$results11 = $pdo->prepare($sql11);
$results11->execute();
$rs_sp11 = $results11->fetch(PDO::FETCH_OBJ);	
return $rs_sp11->CASE_NO ;
}
function JVN_COUNT1($pdo,$MM,$YYY,$CONTROL_STATUS) { 
$sql11 = "SELECT COUNT(ccm.CASE_NO) AS CASE_NO 
FROM CMST_CASE_MAIN ccm
	LEFT JOIN CMST_CASE_JUVENILE ccj ON ccm.CMST_CASE_MAIN_REF =ccj.CMST_CASE_MAIN_REF 
            WHERE ccj.CONTROL_STATUS ='$CONTROL_STATUS'
			AND TO_CHAR(ccj.RECEIVE_DATE, 'MM')='$MM' 
			AND TO_CHAR(ccj.RECEIVE_DATE, 'YYYY')='$YYY' ";	
$results11 = $pdo->prepare($sql11);
$results11->execute();
$rs_sp11 = $results11->fetch(PDO::FETCH_OBJ);	
return $rs_sp11->CASE_NO ;
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>คดี</title>
        <link href="bootstrap.css" rel="stylesheet">
        <link href="signin.css" rel="stylesheet">
    </head>
    <body>
<div class="container"> <!-- bootstrap.css -->	
<?php
include 'menu-main.php'
?>	
<center><h2>จำนวนคดีรายเดือน <?=$login_name;?> </h2>
<h3>ข้อมูล  ณ  <?=date('d-m-Y, G:i:s');?></h3>
</center>
            <fieldset>
                <form class="form-signin" action="" method="post"> 
                    <h4 class="form-signin-heading">เลือกปี</h4>
			
<select name='YYYY' >		
<option value='2021'>2564</option>
<option value='2020'>2563</option>
<option value='2019'>2562</option>
<option value='2018'>2561</option>
<option value='2017'>2560</option>
<option value='2016'>2559</option>
<option value='2015'>2558</option>
</select>
				
                    <button class="btn btn-lg btn-primary btn-block" type="submit">OK</button>
                </form>
            </fieldset>  
<?php
if($_POST['YYYY']=="")
{
	echo "กรุณาเลือกปี";
}
else
{
	$unit_id=substr($user_name,2,4);
	$year0=$_POST['YYYY'];



$sql = "SELECT A.MM_CODE,A.SHOW_RECEIVE_MONTH,'$year0' AS SHOW_RECEIVE_YEAR,
       NVL(E.COUNT_STATUS_TOTAL,0) AS COUNT_STATUS_TOTAL,
       NVL(B.COUNT_STATUS_N,0) AS COUNT_STATUS_N,  --ประกัน
       NVL(C.COUNT_STATUS_Y,0) AS COUNT_STATUS_Y,  --ควบคุม
       NVL(D.COUNT_STATUS_K,0) AS COUNT_STATUS_K   --ไม่ควบคุม
FROM 
(
SELECT 
      MM_CODE ,MONTH_TH AS SHOW_RECEIVE_MONTH
FROM TABT_MONTH_REPORT tmr 
) A 
LEFT JOIN 
(
SELECT  B1.RECEIVE_MONTH,COUNT(B1.CJ_CMST_JUVENILE_REF) AS COUNT_STATUS_N
   FROM
    (SELECT 
       DISTINCT RECEIVE_MONTH ,CONTROL_STATUS ,CONTROL_STATUS_TXT  ,CJ_CMST_JUVENILE_REF ,JVN_CARD_ID ,JVN_FNAME ,JVN_LNAME 
       FROM VDTL_CMST_CASE_MAIN_POLICE 
       WHERE   CONTROL_STATUS  IS NOT NULL AND CONTROL_STATUS  = 'N' AND TO_CHAR(RECEIVE_DATE, 'YYYY') = '$year0' 
     ) B1 GROUP BY B1.RECEIVE_MONTH
) B ON A.MM_CODE =B.RECEIVE_MONTH
     LEFT JOIN 
(
SELECT  C1.RECEIVE_MONTH,COUNT(C1.CJ_CMST_JUVENILE_REF) AS COUNT_STATUS_Y
   FROM
    (SELECT 
       DISTINCT RECEIVE_MONTH ,CONTROL_STATUS ,CONTROL_STATUS_TXT  ,CJ_CMST_JUVENILE_REF ,JVN_CARD_ID ,JVN_FNAME ,JVN_LNAME 
       FROM VDTL_CMST_CASE_MAIN_POLICE 
       WHERE   CONTROL_STATUS  IS NOT NULL AND CONTROL_STATUS  = 'Y' AND TO_CHAR(RECEIVE_DATE, 'YYYY') = '$year0' 
     ) C1 GROUP BY C1.RECEIVE_MONTH
) C ON A.MM_CODE =C.RECEIVE_MONTH
     LEFT JOIN 
(
SELECT  D1.RECEIVE_MONTH,COUNT(D1.CJ_CMST_JUVENILE_REF) AS COUNT_STATUS_K
   FROM
    (SELECT 
       DISTINCT RECEIVE_MONTH ,CONTROL_STATUS ,CONTROL_STATUS_TXT  ,CJ_CMST_JUVENILE_REF ,JVN_CARD_ID ,JVN_FNAME ,JVN_LNAME 
       FROM VDTL_CMST_CASE_MAIN_POLICE 
       WHERE   CONTROL_STATUS  IS NOT NULL AND CONTROL_STATUS  = 'K' AND TO_CHAR(RECEIVE_DATE, 'YYYY') = '$year0' 
     ) D1 GROUP BY D1.RECEIVE_MONTH
) D ON A.MM_CODE =D.RECEIVE_MONTH
LEFT JOIN 
(
 SELECT  E1.RECEIVE_MONTH,COUNT(E1.CJ_CMST_JUVENILE_REF) AS COUNT_STATUS_TOTAL
 FROM
    (SELECT 
       DISTINCT RECEIVE_MONTH ,CONTROL_STATUS ,CONTROL_STATUS_TXT  ,CJ_CMST_JUVENILE_REF ,JVN_CARD_ID ,JVN_FNAME ,JVN_LNAME 
       FROM VDTL_CMST_CASE_MAIN_POLICE 
       WHERE   CONTROL_STATUS  IS NOT NULL AND TO_CHAR(RECEIVE_DATE, 'YYYY') = '$year0' 
     ) E1 GROUP BY E1.RECEIVE_MONTH
) E ON A.MM_CODE = E.RECEIVE_MONTH
ORDER BY A.MM_CODE ";	
				
$results = $pdo->prepare($sql);
$results->execute();
$rs_sp = $results->fetchAll(PDO::FETCH_OBJ);
?>            
            
คดีสระสม ปี <?=$year0+543;?> หน่วย:คน
<table class="table table-striped table-hover table-bordered" style="text-align:center" align="center" width="50%">
	<tbody>
	<tr class="active" style="font-weight:bold;"> 
		<td width="2%">ที่</td>
		<td width="10%">คดีรับใหม่ เดือน</td>
		<td width="10%">รวม(คน)</td>
		<td width="10%">ประกัน</td>
		<td width="10%">ควบคุม</td>
		<td width="10%">ไม่ควบคุม</td>
		<td width="10%">ดูรายหน่วยงาน</td>
		
	</tr>
<?php
$total_sum = 0;
$total_sumY = 0;
$total_sumN = 0;
$total_sumK = 0;
$no = 1;
foreach ($rs_sp as $rs) {
$total_sum +=$rs->COUNT_STATUS_TOTAL;
$total_sumY +=$rs->COUNT_STATUS_Y;
$total_sumN +=$rs->COUNT_STATUS_N;
$total_sumK +=$rs->COUNT_STATUS_K;
?>	
	<tr> 
		<td width="2%"><?=($rs->MM_CODE)/1;?></td>
		<td width="10%">
		<a href="cms_jvn_all_list.php?MM2=<?=$rs->MM_CODE;?>&&year0=<?=$year0;?>" >
		<?=$rs->SHOW_RECEIVE_MONTH;?> <?=$year0+543;?>
		</a></td>
		<td width="10%"><?=$rs->COUNT_STATUS_TOTAL;?></td>
		<td width="10%"><?=$rs->COUNT_STATUS_N;?></td>
		<td width="10%"><?=$rs->COUNT_STATUS_Y;?></td>
		<td width="10%"><?=$rs->COUNT_STATUS_K;?></td>
		<td width="10%"><a href="cms_jvn_all1_unit.php?MM=<?=$rs->MM_CODE;?>&&YYYY=<?=$year0;?>" >
		ดูรายหน่วยงาน</a></td>
		
	</tr>	
<?php
$no++;
}
?>
	<tr > 
		<td width="2%">-</td>
		<td width="10%">รวม</td>
		<td width="10%"><?=$total_sum;?></td>
		<td width="10%"><?=$total_sumN;?></td>
		<td width="10%"><?=$total_sumY;?></td>
		<td width="10%"><?=$total_sumK;?></td>
	</tr>
	</tbody>
</table> 

<?php
}
?>
        </div> <!-- /container -->
    </body>
</html>
