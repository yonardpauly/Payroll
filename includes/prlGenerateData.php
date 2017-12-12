<?php
if (isset($_GET['PayrollID'])){
	$PayrollID = $_GET['PayrollID'];
} elseif (isset($_POST['PayrollID'])){
	$PayrollID = $_POST['PayrollID'];
} else {
	unset($PayrollID);
}
$Status = GetOpenCloseStr(GetPayrollRow($PayrollID, $db,11));
if ($Status=='Closed') {
   exit("Payroll is Closed. Re-open first...");
}
if (isset($_POST['submit'])) {
   exit("Contact Administrator...");
} else {
	$sql="DELETE FROM prlpayrolltrans WHERE payrollid ='" . $PayrollID . "'";
	$Postdelptrans= DB_query($sql,$db);
	$PayPeriodID = GetPayrollRow($PayrollID, $db,2);
	$FSMonthRow = GetPayrollRow($PayrollID, $db,5);
	$FSYearRow = GetPayrollRow($PayrollID, $db,6);
	$sql = 'SELECT employeeid,periodrate,hourlyrate
			FROM prlemployeemaster 
			WHERE prlemployeemaster.payperiodid = '.$PayPeriodID.' and prlemployeemaster.active=0'; 
	$ChartDetailsNotSetUpResult = DB_query($sql,$db,_('Could not test to see that all detail records properly initiated'));
	if(DB_num_rows($ChartDetailsNotSetUpResult)>0)
	{
			$sql = 'INSERT INTO prlpayrolltrans(employeeid,periodrate,hourlyrate)
				SELECT employeeid,periodrate,hourlyrate
				FROM prlemployeemaster
				WHERE prlemployeemaster.payperiodid = '.$PayPeriodID.' and prlemployeemaster.active=0';
			$ErrMsg = _('Inserting new chart details records required failed because');
			$InsChartDetailsRecords = DB_query($sql,$db,$ErrMsg);
			$sql = "UPDATE prlpayrolltrans SET
		          payrollid='" . $PayrollID . "'
			WHERE payrollid = ''";
			$PostPrd = DB_query($sql,$db);
			
			$sql = "UPDATE prlpayrolltrans SET fsmonth=$FSMonthRow, fsyear=$FSYearRow
				WHERE prlpayrolltrans.payrollid='" . $PayrollID . "'";			
			$PostFSPeriod = DB_query($sql,$db);		
	} else {			
		exit("No Employees Records Match....");
	}
	
}

?>