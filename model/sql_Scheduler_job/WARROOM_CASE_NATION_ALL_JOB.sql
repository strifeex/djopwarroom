BEGIN MERGE
INTO    WARROOM_CASE_NATION_ALL d
USING   (
        	SELECT RECEIVE_YEAR, ไม่ระบุ, อื่น, เวียดนาม, พม่า, ลาว, กัมพูชา, จีน, ไทย, ไทยไม่ได้แจ้งเกิด, บรูไน, อินโดนีเซีย, มาเลเซีย, ฟิลิปปินส์, สิงคโปร์, SYSTIMESTAMP FROM (
				SELECT RECEIVE_YEAR, JVN_NATION, COUNT(JVN_ID) AS amount FROM VDTL_CMST_CASE_MAIN_HD2
				WHERE RECEIVE_YEAR = to_char(sysdate, 'YYYY')+543 
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
					'12' ฟิลิปปินส์,
					'13' สิงคโปร์,
					'00' ไม่ระบุ
			    )
			)
        ) s
ON      (s.RECEIVE_YEAR = d.YEAR)
WHEN NOT MATCHED THEN
INSERT (YEAR, JVN_NATION0, JVN_NATION1, JVN_NATION2, JVN_NATION3, JVN_NATION4, JVN_NATION5, 
JVN_NATION6, JVN_NATION7, JVN_NATION8, JVN_NATION9, JVN_NATION10, JVN_NATION11, JVN_NATION12, JVN_NATION13, UPDATE_TIME) 
VALUES (RECEIVE_YEAR, ไม่ระบุ, อื่น, เวียดนาม, พม่า, ลาว, กัมพูชา, จีน, ไทย, ไทยไม่ได้แจ้งเกิด, บรูไน, อินโดนีเซีย, มาเลเซีย, ฟิลิปปินส์, สิงคโปร์, SYSTIMESTAMP) 
WHEN MATCHED THEN 
UPDATE 
SET     JVN_NATION0 = ไม่ระบุ, 
        JVN_NATION1 = อื่น, 
        JVN_NATION2 = เวียดนาม, 
        JVN_NATION3 = พม่า, 
		JVN_NATION4 = ลาว, 
		JVN_NATION5 = กัมพูชา, 
		JVN_NATION6 = จีน, 
		JVN_NATION7 = ไทย, 
		JVN_NATION8 = ไทยไม่ได้แจ้งเกิด, 
		JVN_NATION9 = บรูไน, 
		JVN_NATION10 = อินโดนีเซีย, 
		JVN_NATION11 = มาเลเซีย, 
		JVN_NATION12 = ฟิลิปปินส์, 
		JVN_NATION13 = สิงคโปร์, 
        UPDATE_TIME = SYSTIMESTAMP; END;