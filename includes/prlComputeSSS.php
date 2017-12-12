<?php
if (isset($_GET['PayrollID'])){
	$PayrollID = $_GET['PayrollID'];
} elseif (isset($_POST['PayrollID'])){
	$PayrollID = $_POST['PayrollID'];
} else {
	unset($PayrollID);
}
$FSMonthRow=GetPayrollRow($PayrollID, $db,5);
$FSYearRow=GetPayrollRow($PayrollID, $db,6);
$DeductSSS = GetYesNoStr(GetPayrollRow($PayrollID, $db,7));
$Status = GetOpenCloseStr(GetPayrollRow($PayrollID, $db,11));
if ($Status=='Closed') {
   exit("Payroll is Closed. Re-open first...");
}
if (isset($_POST['submit'])) {
   exit("Contact Administrator...");
} else {
	$sql="DELETE FROM prlempsssfile WHERE payrollid ='" . $PayrollID . "'";
	$Postdelsss= DB_query($sql,$db);

	$sql = "UPDATE prlpayrolltrans SET	sss=0
				WHERE payrollid ='" . $PayrollID . "'";
	$RePostSSS= DB_query($sql,$db);	
	
	if ($DeductSSS=='Yes') {
		$sql = "SELECT counterindex,payrollid,employeeid,basicpay,absent,late,otpay,fsmonth,fsyear
				FROM prlpayrolltrans
				WHERE prlpayrolltrans.payrollid='" . $PayrollID . "'";
		$PayDetails = DB_query($sql,$db);
		if(DB_num_rows($PayDetails)>0)
		{
			while ($myrow = DB_fetch_array($PayDetails))
			{	
				$sql = "SELECT sum(grosspay) AS Gross
					FROM prlpayrolltrans
					WHERE prlpayrolltrans.employeeid='" . $myrow['employeeid'] . "'
					AND prlpayrolltrans.fsmonth='" . $FSMonthRow . "'
					AND prlpayrolltrans.fsyear='" . $FSYearRow . "'";
					$SSSDetails = DB_query($sql,$db);
					if(DB_num_rows($SSSDetails)>0)
					{	
						$ssrow=DB_fetch_array($SSSDetails);
						$SSSGP=$ssrow['Gross'];
						if ($SSSGP>0 or $SSSGP<>null) {
									 $myssrow = GetSSSRow($SSSGP, $db);
										$sql = "INSERT INTO prlempsssfile (		
												payrollid,
												employeeid,
												grosspay,				
												rangefrom,
												rangeto,
												salarycredit,
												employerss,
												employerec,
												employeess,
												total,
												fsmonth,
												fsyear)
												VALUES ('$PayrollID', 
													'" . $myrow['employeeid'] . "',
													'$SSSGP',
													'". $myssrow['rangefrom'] ."',
													'". $myssrow['rangeto'] ."',
													'". $myssrow['salarycredit'] ."',
													'". $myssrow['employerss'] ."',
													'". $myssrow['employerec'] ."',
													'". $myssrow['employeess'] ."',
													'". $myssrow['total'] ."',
													'" . $myrow['fsmonth'] . "',
													'" . $myrow['fsyear'] . "'
													)";
												$ErrMsg = _('Inserting SSS File failed.');
												$InsSSSRecords = DB_query($sql,$db,$ErrMsg);
						} //if sssgp>0
					} //dbnumross sssdetials>0	
			}  //end of while
		}  //dbnumrows paydetails > 0
	} //deduct sss=yes
	
	//posting to payroll trans for sss
	if ($DeductSSS=='Yes') {
		$sql = "SELECT counterindex,payrollid,employeeid,basicpay,absent,late,otpay,fsmonth,fsyear
				FROM prlpayrolltrans
				WHERE prlpayrolltrans.payrollid='" . $PayrollID . "'";
		$PayDetails = DB_query($sql,$db);
		if(DB_num_rows($PayDetails)>0)
		{
			while ($myrow = DB_fetch_array($PayDetails))
			{	
			$sql = "SELECT employeess
					FROM prlempsssfile
			        WHERE prlempsssfile.employeeid='" . $myrow['employeeid'] . "'
					AND prlempsssfile.payrollid='" . $PayrollID . "'";		
					$SSSDetails = DB_query($sql,$db);
					if(DB_num_rows($SSSDetails)>0)
					{
					    $sssrow=DB_fetch_array($SSSDetails);
						$SSSPayment=$sssrow['employeess'];
						$sql = 'UPDATE prlpayrolltrans SET sss='.$SSSPayment.'
					     WHERE counterindex = ' . $myrow['counterindex'];
					    $PostSSSPay = DB_query($sql,$db);
					}
			}
		}
	}
} //isset post submit
?>