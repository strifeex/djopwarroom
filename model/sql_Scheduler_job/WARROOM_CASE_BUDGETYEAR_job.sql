BEGIN
  DBMS_SCHEDULER.CREATE_JOB (
   job_name                 =>  'WARROOM_CASE_BUDGETYEAR_job', 
   job_type                 =>  'PLSQL_BLOCK',
   job_action               =>  'BEGIN MERGE
INTO    WARROOM_CASE_BUDGETYEAR_ALL d
USING   (
        	SELECT headYear, N, Y, K, N+Y+K AS TOTAL, SYSTIMESTAMP FROM(
				SELECT * FROM (
					SELECT to_char(sysdate, ''YYYY'')+543-1 AS headYear, JVN_ID, NVL2(CONTROL_STATUS,CONTROL_STATUS,0) AS stat FROM VDTL_CMST_CASE_MAIN_HD2 
					WHERE RECEIVE_DATE BETWEEN to_date(''01-OCT-''||(to_char(sysdate, ''YY'')-1), ''DD-MONTH-YY'') 
					AND to_date(TO_CHAR ((ADD_MONTHS (''01-OCT-''||(to_char(sysdate, ''YY'')-1),11)), ''YYYY-MM-DD'') || '' 23:59:59'', ''YYYY-MM-DD HH24:MI:SS'')
				)
				PIVOT(
				    COUNT(JVN_ID) 
				    FOR stat
				    IN ( 
				        ''N'' N,
				        ''Y'' Y,
				        ''K'' K
				    )
				)
			)
        ) s
ON      (s.headYear = d.headYear)
WHEN NOT MATCHED THEN
INSERT (YEAR, ENSURE, CONTROL, NOCONTROL, TOTAL, UPDATE_TIME) 
VALUES (headYear, N, Y, K,  N+Y+K, SYSTIMESTAMP) 
WHEN MATCHED THEN 
UPDATE 
SET     ENSURE = N, 
        CONTROL = Y, 
        NOCONTROL = K, 
        TOTAL = TOTAL, 
        UPDATE_TIME = SYSTIMESTAMP; END;', 
    start_date				=>	to_date('06-JUL-2022 23:55:00','DD-MON-YYYY HH24:MI:SS'),
    repeat_interval			=>	'freq=daily;interval=1',
    enabled					=>	true
   );
END;


BEGIN
DBMS_SCHEDULER.drop_job (job_name => 'WARROOM_CASE_BUDGETYEAR_job');
END;