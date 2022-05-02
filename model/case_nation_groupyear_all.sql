SELECT * FROM (
	SELECT RECEIVE_YEAR, JVN_NATION, COUNT(JVN_ID) AS amount FROM VDTL_CMST_CASE_MAIN_HD2
	WHERE RECEIVE_DATE >= to_date('01/01/2018','dd/mm/yyyy') 
	GROUP BY RECEIVE_YEAR, JVN_NATION 
	ORDER BY RECEIVE_YEAR 
) 
PIVOT(
    sum(amount)  
    FOR JVN_NATION
    IN ( 
    '01' อื่น,
		'02' เวียดนาม,
		'03' พม่า,
		'04' ลาว,
		'05' กัมพูชา,
		'06' จีน,
		'07' ไทย,
		'08' ไทยไม่ได้แจ้งเกิด,
		'09' บรูไน,
		'10' อินโดนีเซีย,
		'11' มาเลเซีย,
		-- '12' ฟิลิปปินส์,
		-- '13' สิงคโปร์,
		'00' ไม่ระบุ
    )
)
ORDER BY RECEIVE_YEAR